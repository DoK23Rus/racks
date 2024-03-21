<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRackInputPort
{
    /**
     * @param  CreateRackRequestModel  $request
     * @return ViewModel
     */
    public function createRack(CreateRackRequestModel $request): ViewModel;
}
