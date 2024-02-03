<?php

namespace App\Http\Controllers\RegionControllers;

use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/*
|--------------------------------------------------------------------------
| RAPID APPROACH
|--------------------------------------------------------------------------
|
| Not much business logic, not likely to change.
|
*/

class GetAllRegionsController extends Controller
{
    public function __construct(
        private readonly RegionRepository $regionRepository
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->regionRepository->getAll(
            $request->route('per_page')
        );
    }
}
