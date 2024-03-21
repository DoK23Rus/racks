<?php

namespace App\Http\Controllers\DeviceControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequests\UpdateDeviceRequest;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceInputPort;
use App\UseCases\DeviceUseCases\UpdateDeviceUseCase\UpdateDeviceRequestModel;
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
 * API Docs: @see \App\Http\Controllers\DeviceControllers\Swagger\UpdateDeviceController
 */
class UpdateDeviceController extends Controller
{
    /**
     * @param  UpdateDeviceInputPort  $interactor
     */
    public function __construct(
        private readonly UpdateDeviceInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  UpdateDeviceRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(UpdateDeviceRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->updateDevice(
            App()->makeWith(UpdateDeviceRequestModel::class,
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
