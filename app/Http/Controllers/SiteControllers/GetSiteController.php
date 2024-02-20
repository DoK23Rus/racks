<?php

namespace App\Http\Controllers\SiteControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequests\GetSiteRequest;
use App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteInputPort;
use App\UseCases\SiteUseCases\GetSiteUseCase\GetSiteRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

/**
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\GetSiteController
 */
class GetSiteController extends Controller
{
    /**
     * @param  GetSiteInputPort  $interactor
     */
    public function __construct(
        private readonly GetSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  GetSiteRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(GetSiteRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getSite(
            App()->makeWith(GetSiteRequestModel::class, ['id' => $request->route('id')])
        );
        if ($viewModel instanceof JsonResourceViewModel) {
            return response()->json(
                ['data' => $viewModel->getResource()->toArray($request)],
                $viewModel->getStatusCode()
            );
        }

        return null;
    }
}
