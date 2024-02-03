<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRackInputPort
{
    public function updateRack(UpdateRackRequestModel $request): ViewModel;
}
