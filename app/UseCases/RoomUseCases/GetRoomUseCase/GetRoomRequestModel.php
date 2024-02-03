<?php

namespace App\UseCases\RoomUseCases\GetRoomUseCase;

class GetRoomRequestModel
{
    public function __construct(
        private readonly int $id
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}
