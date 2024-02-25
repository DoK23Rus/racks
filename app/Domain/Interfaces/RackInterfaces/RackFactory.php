<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackRequestModel;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackRequestModel;

interface RackFactory
{
    /**
     * @param  CreateRackRequestModel  $request
     * @return RackEntity|RackBusinessRules
     */
    public function makeFromCreateRequest(CreateRackRequestModel $request): RackEntity|RackBusinessRules;

    /**
     * @param  UpdateRackRequestModel  $request
     * @return RackEntity|RackBusinessRules
     */
    public function makeFromPatchRequest(UpdateRackRequestModel $request): RackEntity|RackBusinessRules;
}
