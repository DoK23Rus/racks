<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetDeviceInputPort
{
    /**
     * @param  GetDeviceRequestModel  $request
     * @return ViewModel
     */
    public function getDevice(GetDeviceRequestModel $request): ViewModel;
}
