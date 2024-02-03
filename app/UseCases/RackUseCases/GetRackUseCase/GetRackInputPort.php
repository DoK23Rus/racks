<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRackInputPort
{
    public function getRack(GetRackRequestModel $request): ViewModel;
}
