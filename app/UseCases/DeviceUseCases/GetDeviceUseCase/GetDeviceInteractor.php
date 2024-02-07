<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Domain\Interfaces\ViewModel;

class GetDeviceInteractor implements GetDeviceInputPort
{
    public function __construct(
        private readonly GetDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository
    ) {
    }

    public function getDevice(GetDeviceRequestModel $request): ViewModel
    {
        try {
            $device = $this->deviceRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDevice(
                App()->makeWith(GetDeviceResponseModel::class, ['device' => null])
            );
        }

        return $this->output->retrieveDevice(
            App()->makeWith(GetDeviceResponseModel::class, ['device' => $device])
        );
    }
}
