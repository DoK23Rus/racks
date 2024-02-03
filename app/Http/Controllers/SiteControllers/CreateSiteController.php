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

class CreateSiteController extends Controller
{
    public function __construct(
        private readonly CreateSiteInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

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
