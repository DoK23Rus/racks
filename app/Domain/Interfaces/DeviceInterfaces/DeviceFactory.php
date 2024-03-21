<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceRequestModel;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceRequestModel;

interface DeviceFactory
{
    /**
     * @param  CreateDeviceRequestModel  $request
     * @return DeviceEntity
     */
    public function makeFromPostRequest(CreateDeviceRequestModel $request): DeviceEntity;

    /**
     * @param  UpdateDeviceRequestModel  $request
     * @return DeviceEntity
     */
    public function makeFromPatchRequest(UpdateDeviceRequestModel $request): DeviceEntity;
}
