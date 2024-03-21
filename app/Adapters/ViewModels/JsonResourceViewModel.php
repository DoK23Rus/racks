<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\ViewModel;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * View model for JSON resource
 */
class JsonResourceViewModel implements ViewModel
{
    /**
     * @var JsonResource
     */
    private JsonResource $resource;

    /**
     * @var int
     */
    private int $statusCode;

    /**
     * @param  JsonResource  $resource
     * @param  int  $statusCode
     */
    public function __construct(JsonResource $resource, int $statusCode = 200)
    {
        $this->resource = $resource;
        $this->statusCode = $statusCode;
    }

    /**
     * @return JsonResource
     */
    public function getResource(): JsonResource
    {
        return $this->resource;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
