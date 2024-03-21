<?php

namespace App\UseCases\RackUseCases\DeleteRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRackOutputPort
{
    /**
     * @param  DeleteRackResponseModel  $response
     * @return ViewModel
     */
    public function rackDeleted(DeleteRackResponseModel $response): ViewModel;

    /**
     * @param  DeleteRackResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRack(DeleteRackResponseModel $response): ViewModel;

    /**
     * @param  DeleteRackResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToDeleteRack(DeleteRackResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  DeleteRackResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(DeleteRackResponseModel $response): ViewModel;
}
