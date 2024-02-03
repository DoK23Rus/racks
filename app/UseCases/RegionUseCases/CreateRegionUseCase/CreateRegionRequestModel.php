<?php

namespace App\UseCases\RegionUseCases\CreateRegionUseCase;

class CreateRegionRequestModel
{
    /**
     * @param  array<mixed>  $attributes
     */
    public function __construct(
        private readonly array $attributes
    ) {
    }

    public function getName(): string
    {
        return $this->attributes['name'];
    }
}
