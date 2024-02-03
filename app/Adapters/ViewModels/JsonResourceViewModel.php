<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\ViewModel;
use Illuminate\Http\Resources\Json\JsonResource;

class JsonResourceViewModel implements ViewModel
{
    private JsonResource $resource;

    private int $statusCode;

    public function __construct(JsonResource $resource, int $statusCode = 200)
    {
        $this->resource = $resource;
        $this->statusCode = $statusCode;
    }

    public function getResource(): JsonResource
    {
        return $this->resource;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
