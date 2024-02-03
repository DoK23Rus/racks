<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class UpdateRackResponseModel
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
