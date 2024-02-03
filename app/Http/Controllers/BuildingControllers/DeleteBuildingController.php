<?php

namespace App\Http\Controllers\BuildingControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequests\DeleteBuildingRequest;
use App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingInputPort;
use App\UseCases\BuildingUseCases\DeleteBuildingUseCase\DeleteBuildingRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class DeleteBuildingController extends Controller
{
    public function __construct(
        private readonly DeleteBuildingInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(DeleteBuildingRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->deleteBuilding(
            App()->makeWith(DeleteBuildingRequestModel::class,
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
