<?php

namespace App\Domain\Interfaces\DeviceInterfaces;

use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceRequestModel;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceRequestModel;

interface DeviceFactory
{
    public function makeFromId(int $id): DeviceEntity;

    public function makeFromPostRequest(CreateDeviceRequestModel $request): DeviceEntity;

    public function makeFromPutRequest(UpdateDeviceRequestModel $request): DeviceEntity;
}
