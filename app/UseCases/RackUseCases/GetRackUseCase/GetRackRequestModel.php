<?php

namespace App\UseCases\RackUseCases\GetRackUseCase;

class GetRackRequestModel
{
    /**
     * @param  int  $id
     */
    public function __construct(
        private readonly int $id
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
