<?php

namespace App\Http\Controllers\BuildingControllers;

use App\Domain\Interfaces\BuildingInterfaces\BuildingRepository;
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

class GetAllBuildingsController extends Controller
{
    public function __construct(
        private readonly BuildingRepository $buildingRepository
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->buildingRepository->getAll(
            $request->route('per_page')
        );
    }
}
