<?php

namespace App\Http\Controllers\SiteControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\SiteRequests\DeleteSiteRequest;
use App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteInputPort;
use App\UseCases\SiteUseCases\DeleteSiteUseCase\DeleteSiteRequestModel;
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
 * API Docs: @see \App\Http\Controllers\SiteControllers\Swagger\DeleteSiteController
 */
class DeleteSiteController extends Controller
{
    /**
     * @param  DeleteSiteInputPort  $interactor
     */
    public function __construct(
        private readonly DeleteSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  DeleteSiteRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(DeleteSiteRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->deleteSite(
            App()->makeWith(DeleteSiteRequestModel::class,
                ['id' => $request->route('id'), 'user' => $request->user()])
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
