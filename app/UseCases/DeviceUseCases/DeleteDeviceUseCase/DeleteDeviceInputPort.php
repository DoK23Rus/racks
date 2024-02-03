<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDeviceInputPort
{
    public function deleteDevice(DeleteDeviceRequestModel $request): ViewModel;
}
