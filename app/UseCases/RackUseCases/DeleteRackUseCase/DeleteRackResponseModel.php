<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class DeleteRackResponseModel
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
