<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceFactory;
use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateDeviceInteractor implements UpdateDeviceInputPort
{
    /**
     * @param  UpdateDeviceOutputPort  $output
     * @param  DeviceRepository  $deviceRepository
     * @param  RackRepository  $rackRepository
     * @param  DeviceFactory  $deviceFactory
     */
    public function __construct(
        private readonly UpdateDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository,
        private readonly RackRepository $rackRepository,
        private readonly DeviceFactory $deviceFactory,
    ) {
    }

    /**
     * @param  UpdateDeviceRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateDevice(UpdateDeviceRequestModel $request): ViewModel
    {
        $deviceUpdating = $this->deviceFactory->makeFromPatchRequest($request);

        // Try to get device
        try {
            $device = $this->deviceRepository->getById($deviceUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDevice(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        // User department check
        if (! Gate::allows('departmentCheck', $device->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        $deviceUpdating->setUpdatedBy($request->getUserName());

        // If no units in request data
        if (! count($deviceUpdating->getUnits()->toArray())) {
            $deviceUpdating->setUnits($device->getUnits());
        }

        $rack = $this->rackRepository->getById($device->getRackId());

        // Check device units exist
        if (! $rack->hasDeviceUnits($deviceUpdating)) {
            return $this->output->noSuchUnits(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        DB::beginTransaction();

        // Try to update
        try {
            $this->rackRepository->lockById($device->getRackId());

            $rack = $this->rackRepository->getById($device->getRackId());

            // Delete old units from rack
            $rack->deleteOldBusyUnits(
                $device->getUnits()->toArray(),
                $device->getLocation()
            );

            // Check device can be moved
            if (! $rack->isDeviceMovingValid($device, $deviceUpdating)) {
                return $this->output->unitsAreBusy(
                    App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
                );
            }

            // Add new units to rack
            $rack->addNewBusyUnits(
                $request->getUnits(),
                $request->getLocation()
            );

            $this->rackRepository->updateBusyUnits($rack);

            try {
                $deviceUpdating = $this->deviceRepository->update($deviceUpdating);
            } catch (\Exception $e) {
                return $this->output->unableToUpdateDevice(
                    App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating]),
                    $e
                );
            }
        } catch (\Exception $e) {
            DB::rollback();

            return $this->output->updateFailed(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Update Device --> pk {$deviceUpdating->getId()}", [
            'old_data' => $device->toArray(),
            'new_data' => $deviceUpdating->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->deviceUpdated(
            App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
        );
    }
}
