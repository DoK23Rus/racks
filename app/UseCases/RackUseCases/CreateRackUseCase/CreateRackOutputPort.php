<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRackOutputPort
{
    public function rackCreated(CreateRackResponseModel $response): ViewModel;

    public function noSuchRoom(CreateRackResponseModel $response): ViewModel;

    public function rackNameException(CreateRackResponseModel $response): ViewModel;

    public function unableToCreateRack(CreateRackResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(CreateRackResponseModel $response): ViewModel;
}
