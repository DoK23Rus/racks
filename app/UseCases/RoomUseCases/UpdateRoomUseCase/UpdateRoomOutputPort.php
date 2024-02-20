<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRoomOutputPort
{
    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     */
    public function roomUpdated(UpdateRoomResponseModel $response): ViewModel;

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     */
    public function noSuchRoom(UpdateRoomResponseModel $response): ViewModel;

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     */
    public function roomNameException(UpdateRoomResponseModel $response): ViewModel;

    /**
     * @param  UpdateRoomResponseModel  $response
     * @param  \Throwable  $e
     * @return ViewModel
     */
    public function unableToUpdateRoom(UpdateRoomResponseModel $response, \Throwable $e): ViewModel;

    /**
     * @param  UpdateRoomResponseModel  $response
     * @return ViewModel
     */
    public function permissionException(UpdateRoomResponseModel $response): ViewModel;
}
