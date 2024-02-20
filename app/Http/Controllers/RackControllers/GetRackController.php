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

/**
 * API Docs: @see \App\Http\Controllers\RackControllers\Swagger\GetRackController
 */
class GetRackController extends Controller
{
    /**
     * @param  GetRackInputPort  $interactor
     */
    public function __construct(
        private readonly GetRackInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  GetRackRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
