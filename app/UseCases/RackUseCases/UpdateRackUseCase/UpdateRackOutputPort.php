<?php

namespace App\UseCases\RackUseCases\UpdateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRackOutputPort
{
    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     */
    public function rackUpdated(UpdateRackResponseModel $response): ViewModel;

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRack(UpdateRackResponseModel $response): ViewModel;

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     */
    public function rackNameException(UpdateRackResponseModel $response): ViewModel;

    /**
     * @param  UpdateRackResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateRack(UpdateRackResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  UpdateRackResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(UpdateRackResponseModel $response): ViewModel;
}
