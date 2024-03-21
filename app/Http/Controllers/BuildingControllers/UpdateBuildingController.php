<?php

namespace App\Http\Controllers\BuildingControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequests\UpdateBuildingRequest;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingInputPort;
use App\UseCases\BuildingUseCases\UpdateBuildingUseCase\UpdateBuildingRequestModel;
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
 * API Docs: @see \App\Http\Controllers\BuildingControllers\Swagger\UpdateBuildingController
 */
class UpdateBuildingController extends Controller
{
    /**
     * @param  UpdateBuildingInputPort  $interactor
     */
    public function __construct(
        private readonly UpdateBuildingInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  UpdateBuildingRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(UpdateBuildingRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->updateBuilding(
            App()->makeWith(UpdateBuildingRequestModel::class,
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
