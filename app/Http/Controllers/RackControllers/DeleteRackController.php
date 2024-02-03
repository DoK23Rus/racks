<?php

namespace App\Http\Controllers\RackControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RackRequests\DeleteRackRequest;
use App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackInputPort;
use App\UseCases\RackUseCases\DeleteRackUseCase\DeleteRackRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class DeleteRackController extends Controller
{
    public function __construct(
        private readonly DeleteRackInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(DeleteRackRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->deleteRack(
            App()->makeWith(DeleteRackRequestModel::class,
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
