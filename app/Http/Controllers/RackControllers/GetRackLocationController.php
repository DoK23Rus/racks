<?php

namespace App\Http\Controllers\RackControllers;

use App\Domain\Interfaces\RackInterfaces\RackRepository;
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
 * API Docs: @see \App\Http\Controllers\RackControllers\Swagger\GetRackLocationController
 */
class GetRackLocationController extends Controller
{
    /**
     * @param  RackRepository  $rackRepository
     */
    public function __construct(
        private readonly RackRepository $rackRepository,
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
            $rackLocation = $this->rackRepository->getLocation($request->route('id'));

            return response()->json(
                ['data' => $rackLocation[0]]
            );
        } catch (\Exception $e) {
            return response()->json(
                ['data' => ['message' => 'No such rack']], 404
            );
        }
    }
}
