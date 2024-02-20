<?php

namespace App\UseCases\RoomUseCases\DeleteRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface DeleteRoomInputPort
{
    /**
     * @param  DeleteRoomRequestModel  $request
     * @return ViewModel
     */
    public function deleteRoom(DeleteRoomRequestModel $request): ViewModel;
}
