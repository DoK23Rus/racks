<?php

namespace App\Http\Controllers\RackControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RackRequests\CreateRackRequest;
use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackInputPort;
use App\UseCases\RackUseCases\CreateRackUseCase\CreateRackRequestModel;
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
 * API Docs: @see \App\Http\Controllers\RackControllers\Swagger\CreateRackController
 */
class CreateRackController extends Controller
{
    /**
     * @param  CreateRackInputPort  $interactor
     */
    public function __construct(
        private readonly CreateRackInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  CreateRackRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(CreateRackRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->createRack(
            App()->makeWith(CreateRackRequestModel::class,
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
