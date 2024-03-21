<?php

namespace App\Http\Controllers\RegionControllers;

use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| RAPID APPROACH
|--------------------------------------------------------------------------
|
| Not much business logic, not likely to change.
|
*/

/**
 * API Docs: @see \App\Http\Controllers\RegionControllers\Swagger\GetTreeViewController
 */
class GetTreeViewController extends Controller
{
    /**
     * @param  RegionRepository  $regionRepository
     */
    public function __construct(
        private readonly RegionRepository $regionRepository,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json(
            ['data' => $this->regionRepository->getTreeView()]
        );
    }
}
