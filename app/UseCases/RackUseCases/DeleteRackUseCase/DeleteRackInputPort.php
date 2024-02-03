<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRackInputPort
{
    public function deleteRack(DeleteRackRequestModel $request): ViewModel;
}
