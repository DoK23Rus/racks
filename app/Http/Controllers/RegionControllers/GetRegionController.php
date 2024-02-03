<?php

namespace App\Http\Controllers\RegionControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegionRequests\GetRegionRequest;
use App\UseCases\RegionUseCases\GetRegionUseCase\GetRegionInputPort;
use App\UseCases\RegionUseCases\GetRegionUseCase\GetRegionRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class GetRegionController extends Controller
{
    public function __construct(
        private readonly GetRegionInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(GetRegionRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getRegion(
            App()->makeWith(GetRegionRequestModel::class, ['id' => $request->route('id')])
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
