<?php

namespace App\UseCases\DeviceUseCases\CreateDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateDeviceOutputPort
{
    public function deviceCreated(CreateDeviceResponseModel $response): ViewModel;

    public function noSuchUnits(CreateDeviceResponseModel $response): ViewModel;

    public function unitsAreBusy(CreateDeviceResponseModel $response): ViewModel;

    public function creationFailed(CreateDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function noSuchRack(CreateDeviceResponseModel $response): ViewModel;

    public function unableToCreateDevice(CreateDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(CreateDeviceResponseModel $response): ViewModel;
}
