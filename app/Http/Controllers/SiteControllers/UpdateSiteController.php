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

class UpdateSiteController extends Controller
{
    public function __construct(
        private readonly UpdateSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

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
