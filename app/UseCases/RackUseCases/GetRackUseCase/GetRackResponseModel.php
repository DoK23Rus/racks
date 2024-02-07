<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class GetRackResponseModel
{
    public function __construct(
        private readonly ?RackEntity $rack
    ) {
    }

    public function getRack(): ?RackEntity
    {
        return $this->rack;
    }
}
