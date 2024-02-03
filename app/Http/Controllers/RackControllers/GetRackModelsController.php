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

class GetRackModelsController extends Controller
{
    public function __construct(
        private readonly RackRepository $rackRepository,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): JsonResponse
    {
        $vendors = array_values(array_filter($this->rackRepository->getModels()));
        sort($vendors);

        return response()->json([
            'data' => [
                'item_type' => 'rack_model',
                'items' => $vendors,
            ],
        ]);
    }
}
