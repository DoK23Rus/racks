<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRackInputPort
{
    /**
     * @param  UpdateRackRequestModel  $request
     * @return ViewModel
     */
    public function updateRack(UpdateRackRequestModel $request): ViewModel;
}
