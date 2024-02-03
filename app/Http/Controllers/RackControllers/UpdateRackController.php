<?php

namespace App\Http\Controllers\RackControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RackRequests\UpdateRackRequest;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackInputPort;
use App\UseCases\RackUseCases\UpdateRackUseCase\UpdateRackRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class UpdateRackController extends Controller
{
    public function __construct(
        private readonly UpdateRackInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(UpdateRackRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->updateRack(
            App()->makeWith(
                UpdateRackRequestModel::class,
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
