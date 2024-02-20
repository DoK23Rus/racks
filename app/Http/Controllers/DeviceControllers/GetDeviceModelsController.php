<?php

namespace App\Http\Controllers\DeviceControllers;

use App\Domain\Interfaces\DeviceInterfaces\DeviceRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| RAPID APPROACH
|--------------------------------------------------------------------------
|
| Not much business logic, not likely to change.
|
*/

/**
 * API Docs: @see \App\Http\Controllers\DeviceControllers\Swagger\GetDeviceModelsController
 */
class GetDeviceModelsController extends Controller
{
    /**
     * @param  DeviceRepository  $deviceRepository
     */
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $models = array_values(array_filter($this->deviceRepository->getModels()));
        sort($models);

        return response()->json([
            'data' => [
                'item_type' => 'device_model',
                'items' => $models,
            ],
        ]);
    }
}
