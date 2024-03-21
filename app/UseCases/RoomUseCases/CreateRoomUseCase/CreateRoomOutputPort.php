<?php

namespace App\UseCases\RoomUseCases\CreateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface CreateRoomOutputPort
{
    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     */
    public function roomCreated(CreateRoomResponseModel $response): ViewModel;

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     */
    public function noSuchBuilding(CreateRoomResponseModel $response): ViewModel;

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     */
    public function roomNameException(CreateRoomResponseModel $response): ViewModel;

    /**
     * @param  CreateRoomResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToCreateRoom(CreateRoomResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  CreateRoomResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(CreateRoomResponseModel $response): ViewModel;
}
