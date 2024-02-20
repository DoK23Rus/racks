<?php

namespace App\UseCases\RoomUseCases\UpdateRoomUseCase;

use App\Domain\Interfaces\ViewModel;

interface UpdateRoomInputPort
{
    /**
     * @param  UpdateRoomRequestModel  $request
     * @return ViewModel
     */
    public function updateRoom(UpdateRoomRequestModel $request): ViewModel;
}
