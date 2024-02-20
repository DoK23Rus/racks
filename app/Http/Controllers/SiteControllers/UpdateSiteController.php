<?php

namespace App\Http\Controllers\SiteControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequests\UpdateSiteRequest;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteInputPort;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteRequestModel;
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
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\UpdateSiteController
 */
class UpdateSiteController extends Controller
{
    /**
     * @param  UpdateSiteInputPort  $interactor
     */
    public function __construct(
        private readonly UpdateSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  UpdateSiteRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(UpdateSiteRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->updateSite(
            App()->makeWith(
                UpdateSiteRequestModel::class,
                ['attributes' => $request->validated(), 'id' => $request->route('id'), 'user' => $request->user()]
            )
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
