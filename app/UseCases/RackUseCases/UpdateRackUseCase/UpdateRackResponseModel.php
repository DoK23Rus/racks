<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class UpdateRackResponseModel
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
