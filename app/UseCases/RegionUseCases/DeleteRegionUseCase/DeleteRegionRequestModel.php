<?php

namespace App\UseCases\RegionUseCases\DeleteRegionUseCase;

class DeleteRegionRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes
    ) {
    }

    public function getId(): int
    {
        return $this->attributes['id'];
    }
}
