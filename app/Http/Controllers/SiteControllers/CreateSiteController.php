<?php

namespace App\Http\Controllers\SiteControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequests\CreateSiteRequest;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteInputPort;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteRequestModel;
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
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\CreateSiteController
 */
class CreateSiteController extends Controller
{
    /**
     * @param  CreateSiteInputPort  $interactor
     */
    public function __construct(
        private readonly CreateSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  CreateSiteRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(CreateSiteRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->createSite(
            App()->makeWith(CreateSiteRequestModel::class,
                ['attributes' => $request->validated(), 'user' => $request->user()])
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
