<?php

namespace App\Http\Controllers\RoomControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequests\GetRoomRequest;
use App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomInputPort;
use App\UseCases\RoomUseCases\GetRoomUseCase\GetRoomRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class GetRoomController extends Controller
{
    public function __construct(
        private readonly GetRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(GetRoomRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->getRoom(
            App()->makeWith(GetRoomRequestModel::class, ['id' => $request->route('id')])
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
