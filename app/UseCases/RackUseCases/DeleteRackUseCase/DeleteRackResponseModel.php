<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\RackInterfaces\RackEntity;

class DeleteRackResponseModel
{
    /**
     * @param  RackEntity|null  $rack  Null for no such rack response
     */
    public function __construct(
        private readonly ?RackEntity $rack
    ) {
    }

    /**
     * @return RackEntity|null
     */
    public function getRack(): ?RackEntity
    {
        return $this->rack;
    }
}
