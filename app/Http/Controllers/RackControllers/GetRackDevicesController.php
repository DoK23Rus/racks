<?php

namespace App\Http\Controllers\RackControllers;

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

class GetRackDevicesController extends Controller
{
    public function __construct(
        private readonly DeviceRepository $deviceRepository,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $rackDevices = $this->deviceRepository->getByRackId($request->route('id'));

            return response()->json(
                ['data' => $rackDevices]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['data' => ['message' => 'No such rack']], 404
            );
        }
    }
}
