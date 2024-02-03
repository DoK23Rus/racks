<?php

namespace App\UseCases\DeviceUseCases\UpdateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateDeviceOutputPort
{
    public function deviceUpdated(UpdateDeviceResponseModel $response): ViewModel;

    public function noSuchUnits(UpdateDeviceResponseModel $response): ViewModel;

    public function unitsAreBusy(UpdateDeviceResponseModel $response): ViewModel;

    public function updateFailed(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function noSuchDevice(UpdateDeviceResponseModel $response): ViewModel;

    public function unableToUpdateDevice(UpdateDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(UpdateDeviceResponseModel $response): ViewModel;
}
