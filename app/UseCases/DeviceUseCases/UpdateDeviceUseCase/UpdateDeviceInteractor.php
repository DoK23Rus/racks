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
    public function __construct(
        private readonly UpdateDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository,
        private readonly RackRepository $rackRepository,
        private readonly DeviceFactory $deviceFactory,
    ) {
    }

    public function updateDevice(UpdateDeviceRequestModel $request): ViewModel
    {
        $deviceUpdating = $this->deviceFactory->makeFromId($request->getId());

        try {
            $device = $this->deviceRepository->getById($deviceUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDevice(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        if (! Gate::allows('departmentCheck', $device->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        $deviceUpdating = $this->deviceFactory->makeFromPutRequest($request);

        $deviceUpdating->setUpdatedBy($request->getUserName());

        if (! count($deviceUpdating->getUnits()->getArray())) {
            $deviceUpdating->setUnits($device->getUnits());
        }

        $rack = $this->rackRepository->getById($device->getRackId());

        if (! $rack->hasDeviceUnits($deviceUpdating)) {
            return $this->output->noSuchUnits(
                App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
            );
        }

        DB::beginTransaction();

        try {
            $this->rackRepository->lockById($device->getRackId());

            $rack = $this->rackRepository->getById($device->getRackId());

            $rack->deleteOldBusyUnits(
                $device->getUnits()->getArray(),
                $device->getLocation()
            );

            if (! $rack->isDeviceMovingValid($device, $deviceUpdating)) {
                return $this->output->unitsAreBusy(
                    App()->makeWith(UpdateDeviceResponseModel::class, ['device' => $deviceUpdating])
                );
            }

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
