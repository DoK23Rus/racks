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

class GetSiteController extends Controller
{
    public function __construct(
        private readonly GetSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

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
