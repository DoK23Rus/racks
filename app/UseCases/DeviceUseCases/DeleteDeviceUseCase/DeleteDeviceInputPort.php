<?php

namespace App\UseCases\DeviceUseCases\DeleteDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteDeviceInputPort
{
    /**
     * @param  DeleteDeviceRequestModel  $request
     * @return ViewModel
     */
    public function deleteDevice(DeleteDeviceRequestModel $request): ViewModel;
}
