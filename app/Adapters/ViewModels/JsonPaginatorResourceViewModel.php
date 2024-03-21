<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * View model for JSON paginator
 */
class JsonPaginatorResourceViewModel implements ViewModel
{
    /**
     * @var LengthAwarePaginator
     */
    private LengthAwarePaginator $resource;

    /**
     * @param  LengthAwarePaginator  $resource
     */
    public function __construct(LengthAwarePaginator $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getResource(): LengthAwarePaginator
    {
        return $this->resource;
    }
}
