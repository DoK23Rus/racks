<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Domain\Interfaces\RackInterfaces\RackRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteDeviceInteractor implements DeleteDeviceInputPort
{
    /**
     * @param  DeleteDeviceOutputPort  $output
     * @param  DeviceRepository  $deviceRepository
     * @param  RackRepository  $rackRepository
     */
    public function __construct(
        private readonly DeleteDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository,
        private readonly RackRepository $rackRepository
    ) {
    }

    /**
     * @param  DeleteDeviceRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleteDevice(DeleteDeviceRequestModel $request): ViewModel
    {
        // Try to get device
        try {
            $device = $this->deviceRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDevice(
                App()->makeWith(DeleteDeviceResponseModel::class, ['device' => null])
            );
        }

        // User department check
        if (! Gate::allows('departmentCheck', $device->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteDeviceResponseModel::class, ['device' => $device])
            );
        }

        $rack = $this->rackRepository->getById($device->getRackId());

        DB::beginTransaction();

        // Try to delete
        try {
            $this->rackRepository->lockById($rack->getId());

            $rack = $this->rackRepository->getById($rack->getId());

            // Delete old units from rack
            $rack->deleteOldBusyUnits(
                $device->getUnits()->toArray(),
                $device->getLocation()
            );

            $this->rackRepository->updateBusyUnits($rack);

            try {
                $this->deviceRepository->delete($device);
            } catch (\Exception $e) {
                return $this->output->unableToDeleteDevice(
                    App()->makeWith(DeleteDeviceResponseModel::class, ['device' => $device]),
                    $e
                );
            }
        } catch (\Exception $e) {
            DB::rollback();

            return $this->output->deletionFailed(
                App()->makeWith(DeleteDeviceResponseModel::class, ['device' => $device]),
                $e
            );
        }

        DB::commit();

        Log::channel('action_log')->info("Delete Device --> pk {$device->getId()}", [
            'deleted_data' => $device->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->deviceDeleted(
            App()->makeWith(DeleteDeviceResponseModel::class, ['device' => $device])
        );
    }
}
