<?php

namespace App\Http\Controllers\RackControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RackRequests\GetRackRequest;
use App\UseCases\RackUseCases\GetRackUseCase\GetRackInputPort;
use App\UseCases\RackUseCases\GetRackUseCase\GetRackRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class GetRackController extends Controller
{
    public function __construct(
        private readonly GetRackInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(GetRackRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getRack(
            App()->makeWith(GetRackRequestModel::class, ['id' => $request->route('id')])
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
