<?php

namespace App\Domain\Interfaces\RackInterfaces;

use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackRequestModel;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackRequestModel;

interface RackFactory
{
    public function makeFromCreateRequest(CreateRackRequestModel $request): RackEntity|RackBusinessRules;

    public function makeFromPatchRequest(UpdateRackRequestModel $request): RackEntity;
}
