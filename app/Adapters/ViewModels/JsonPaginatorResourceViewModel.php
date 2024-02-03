<?php

namespace App\Adapters\ViewModels;

use App\Domain\Interfaces\ViewModel;
use Illuminate\Pagination\LengthAwarePaginator;

class JsonPaginatorResourceViewModel implements ViewModel
{
    private LengthAwarePaginator $resource;

    public function __construct(LengthAwarePaginator $resource)
    {
        $this->resource = $resource;
    }

    public function getResource(): LengthAwarePaginator
    {
        return $this->resource;
    }
}
