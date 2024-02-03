<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\DeviceInterfaces\DeviceFactory;
use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Domain\Interfaces\ViewModel;

class GetDeviceInteractor implements GetDeviceInputPort
{
    public function __construct(
        private readonly GetDeviceOutputPort $output,
        private readonly DeviceRepository $deviceRepository,
        private readonly DeviceFactory $deviceFactory
    ) {
    }

    public function getDevice(GetDeviceRequestModel $request): ViewModel
    {
        $device = $this->deviceFactory->makeFromId($request->getId());

        try {
            $device = $this->deviceRepository->getById($device->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDevice(
                App()->makeWith(GetDeviceResponseModel::class, ['device' => $device])
            );
        }

        return $this->output->retrieveDevice(
            App()->makeWith(GetDeviceResponseModel::class, ['device' => $device])
        );
    }
}
