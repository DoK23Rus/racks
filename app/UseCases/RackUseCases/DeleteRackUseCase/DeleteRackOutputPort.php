<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRackOutputPort
{
    public function rackDeleted(DeleteRackResponseModel $response): ViewModel;

    public function noSuchRack(DeleteRackResponseModel $response): ViewModel;

    public function unableToDeleteRack(DeleteRackResponseModel $response, \Throwable $e): ViewModel;

    public function permissionException(DeleteRackResponseModel $response): ViewModel;
}
