<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface GetRackOutputPort
{
    /**
     * @param  GetRackResponseModel  $response
     * @return ViewModel
     */
    public function retrieveRack(GetRackResponseModel $response): ViewModel;

    /**
     * @param  GetRackResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRack(GetRackResponseModel $response): ViewModel;
}
