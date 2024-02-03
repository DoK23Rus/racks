<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDeviceOutputPort
{
    public function deviceDeleted(DeleteDeviceResponseModel $response): ViewModel;

    public function noSuchDevice(DeleteDeviceResponseModel $response): ViewModel;

    public function deletionFailed(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function unableToDeleteDevice(DeleteDeviceResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(DeleteDeviceResponseModel $response): ViewModel;
}
