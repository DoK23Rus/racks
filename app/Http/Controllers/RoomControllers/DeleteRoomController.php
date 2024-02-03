<?php

namespace App\Http\Controllers\RoomControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequests\DeleteRoomRequest;
use App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomInputPort;
use App\UseCases\RoomUseCases\DeleteRoomUseCase\DeleteRoomRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class DeleteRoomController extends Controller
{
    public function __construct(
        private readonly DeleteRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(DeleteRoomRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->deleteRoom(
            App()->makeWith(DeleteRoomRequestModel::class,
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
