<?php

namespace App\Http\Controllers\SiteControllers;

use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
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

/**
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\GetAllSitesController
 */
class GetAllSitesController extends Controller
{
    /**
     * @param  SiteRepository  $siteRepository
     */
    public function __construct(
        private readonly SiteRepository $siteRepository
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return LengthAwarePaginator
     */
    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->siteRepository->getAll(
            $request->route('per_page')
        );
    }
}
