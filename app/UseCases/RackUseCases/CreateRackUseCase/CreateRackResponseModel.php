<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class CreateRackResponseModel
{
    /**
     * @param  RackEntity  $rack
     */
    public function __construct(
        private readonly RackEntity $rack
    ) {
    }

    /**
     * @return RackEntity
     */
    public function getRack(): RackEntity
    {
        return $this->rack;
    }
}
