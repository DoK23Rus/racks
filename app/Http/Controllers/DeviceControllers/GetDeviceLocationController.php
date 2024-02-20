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
 * API Docs: @see \App\Http\Controllers\DeviceControllers\Swagger\GetDeviceLocationController
 */
class GetDeviceLocationController extends Controller
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
        try {
            $deviceLocation = $this->deviceRepository->getLocation($request->route('id'));

            return response()->json(
                ['data' => $deviceLocation[0]]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['data' => ['message' => 'No such device']], 404
            );
        }
    }
}
