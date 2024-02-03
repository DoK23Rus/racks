<?php

namespace App\Http\Controllers\DeviceControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeviceRequests\GetDeviceRequest;
use App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceInputPort;
use App\UseCases\DeviceUseCases\GetDeviceUseCase\GetDeviceRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class GetDeviceController extends Controller
{
    public function __construct(
        private readonly GetDeviceInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(GetDeviceRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getDevice(
            App()->makeWith(GetDeviceRequestModel::class, ['id' => $request->route('id')])
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
