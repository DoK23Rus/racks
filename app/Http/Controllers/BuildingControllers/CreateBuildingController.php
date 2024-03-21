<?php

namespace App\Http\Controllers\BuildingControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\BuildingRequests\CreateBuildingRequest;
use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingInputPort;
use App\UseCases\BuildingUseCases\CreateBuildingUseCase\CreateBuildingRequestModel;
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
 * API Docs: @see \App\Http\Controllers\BuildingControllers\Swagger\CreateBuildingController
 */
class CreateBuildingController extends Controller
{
    /**
     * @param  CreateBuildingInputPort  $interactor
     */
    public function __construct(
        private readonly CreateBuildingInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  CreateBuildingRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(CreateBuildingRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->createBuilding(
            App()->makeWith(CreateBuildingRequestModel::class,
                ['attributes' => $request->validated(), 'user' => $request->user()]
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
