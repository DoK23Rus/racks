<?php

namespace App\Http\Controllers\SiteControllers;

use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
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
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\GetSiteLocationController
 */
class GetSiteLocationController extends Controller
{
    /**
     * @param  SiteRepository  $siteRepository
     */
    public function __construct(
        private readonly SiteRepository $siteRepository,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $siteLocation = $this->siteRepository->getLocation($request->route('id'));

            return response()->json(
                ['data' => $siteLocation[0]]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['data' => ['message' => 'No such site']], 404
            );
        }
    }
}
