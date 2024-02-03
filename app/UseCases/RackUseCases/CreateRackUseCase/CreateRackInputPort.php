<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRackInputPort
{
    public function createRack(CreateRackRequestModel $request): ViewModel;
}
