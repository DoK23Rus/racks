<?php

namespace App\UseCases\DeviceUseCases\GetDeviceUseCase;

class GetDeviceRequestModel
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
