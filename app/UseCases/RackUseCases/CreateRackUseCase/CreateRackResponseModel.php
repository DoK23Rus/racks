<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class CreateRackResponseModel
{
    public function __construct(
        private readonly RackEntity $rack
    ) {
    }

    public function getRack(): RackEntity
    {
        return $this->rack;
    }
}
