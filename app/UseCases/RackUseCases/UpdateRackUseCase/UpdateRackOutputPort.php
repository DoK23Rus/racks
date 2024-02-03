<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRackOutputPort
{
    public function rackUpdated(UpdateRackResponseModel $response): ViewModel;

    public function noSuchRack(UpdateRackResponseModel $response): ViewModel;

    public function rackNameException(UpdateRackResponseModel $response): ViewModel;

    public function unableToUpdateRack(UpdateRackResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(UpdateRackResponseModel $response): ViewModel;
}
