<?php

namespace App\Http\Controllers\DeviceControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequests\DeleteDeviceRequest;
use App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceInputPort;
use App\UseCases\DeviceUseCases\DeleteDeviceUseCase\DeleteDeviceRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class DeleteDeviceController extends Controller
{
    public function __construct(
        private readonly DeleteDeviceInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(DeleteDeviceRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->deleteDevice(
            App()->makeWith(DeleteDeviceRequestModel::class,
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
