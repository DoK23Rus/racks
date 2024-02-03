<?php

namespace App\Http\Controllers\BuildingControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequests\GetBuildingRequest;
use App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingInputPort;
use App\UseCases\BuildingUseCases\GetBuildingUseCase\GetBuildingRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SOME SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class GetBuildingController extends Controller
{
    public function __construct(
        private readonly GetBuildingInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(GetBuildingRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getBuilding(
            App()->makeWith(GetBuildingRequestModel::class, ['id' => $request->route('id')])
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
