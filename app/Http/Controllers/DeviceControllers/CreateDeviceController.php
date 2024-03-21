<?php

namespace App\Http\Controllers\DeviceControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequests\CreateDeviceRequest;
use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceInputPort;
use App\UseCases\DeviceUseCases\CreateDeviceUseCase\CreateDeviceRequestModel;
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
 * API Docs: @see \App\Http\Controllers\DeviceControllers\Swagger\CreateDeviceController
 */
class CreateDeviceController extends Controller
{
    /**
     * @param  CreateDeviceInputPort  $interactor
     */
    public function __construct(
        private readonly CreateDeviceInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  CreateDeviceRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(CreateDeviceRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->createDevice(
            App()->makeWith(CreateDeviceRequestModel::class,
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
