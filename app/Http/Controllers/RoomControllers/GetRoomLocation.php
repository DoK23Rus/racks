<?php

namespace App\Http\Controllers\RoomControllers;

use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
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
 * API Docs: @see \App\Http\Controllers\RoomControllers\Swagger\GetRoomLocationController
 */
class GetRoomLocation extends Controller
{
    /**
     * @param  RoomRepository  $roomRepository
     */
    public function __construct(
        private readonly RoomRepository $roomRepository,
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
            $roomLocation = $this->roomRepository->getLocation($request->route('id'));

            return response()->json(
                ['data' => $roomLocation[0]]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['data' => ['message' => 'No such room']], 404
            );
        }
    }
}
