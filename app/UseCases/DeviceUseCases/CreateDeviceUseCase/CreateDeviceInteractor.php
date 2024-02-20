<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceFactory;
use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateDeviceInteractor implements CreateDeviceInputPort
{
    /**
     * @param  CreateDeviceOutputPort  $output
     * @param  DeviceRepository  $deviceRepository
     * @param  RackRepository  $rackRepository
     * @param  DeviceFactory  $deviceFactory
     */
    public function __construct(
        private readonly CreateDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository,
        private readonly RackRepository $rackRepository,
        private readonly DeviceFactory $deviceFactory
    ) {
    }

    /**
     * @param  CreateDeviceRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createDevice(CreateDeviceRequestModel $request): ViewModel
    {
        $device = $this->deviceFactory->makeFromPostRequest($request);

        try {
            $rack = $this->rackRepository->getById($request->getRackId());
        } catch (\Exception $e) {
            return $this->output->noSuchRack(
                App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device])
            );
        }

        if (! $rack->hasDeviceUnits($device)) {
            return $this->output->noSuchUnits(
                App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device])
            );
        }

        if (! Gate::allows('departmentCheck', $rack->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device])
            );
        }

        $device->setUpdatedBy($request->getUserName());

        $device->setDepartmentId($rack->getDepartmentId());

        DB::beginTransaction();

        try {
            $this->rackRepository->lockById($request->getRackId());

            $rack = $this->rackRepository->getById($request->getRackId());

            if (! $rack->isDeviceAddable($device)) {
                return $this->output->unitsAreBusy(
                    App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device])
                );
            }

            $rack->addNewBusyUnits(
                $request->getUnits(),
                $device->getLocation()
            );

            $this->rackRepository->updateBusyUnits($rack);

            $device->setDepartmentId($rack->getDepartmentId());

            try {
                $device = $this->deviceRepository->create($device);

                $device = $device->fresh([]);
            } catch (\Exception $e) {
                return $this->output->unableToCreateDevice(
                    App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device]),
                    $e
                );
            }
        } catch (\Exception $e) {
            DB::rollback();

            return $this->output->creationFailed(
                App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Create Device --> fk {$rack->getId()}", [
            'new_data' => $device->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->deviceCreated(
            App()->makeWith(CreateDeviceResponseModel::class, ['device' => $device])
        );
    }
}
