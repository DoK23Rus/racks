<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRackOutputPort
{
    public function retrieveRack(GetRackResponseModel $response): ViewModel;

    public function noSuchRack(GetRackResponseModel $response): ViewModel;
}
