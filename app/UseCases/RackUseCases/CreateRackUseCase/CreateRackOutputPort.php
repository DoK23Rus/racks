<?php

namespace App\UseCases\RackUseCases\CreateRackUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRackOutputPort
{
    /**
     * @param  CreateRackResponseModel  $response
     * @return ViewModel
     */
    public function rackCreated(CreateRackResponseModel $response): ViewModel;

    /**
     * @param  CreateRackResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRoom(CreateRackResponseModel $response): ViewModel;

    /**
     * @param  CreateRackResponseModel  $response
     * @return ViewModel
     */
    public function rackNameException(CreateRackResponseModel $response): ViewModel;

    /**
     * @param  CreateRackResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateRack(CreateRackResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateRackResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(CreateRackResponseModel $response): ViewModel;
}
