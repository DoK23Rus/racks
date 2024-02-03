<?php

namespace App\Http\Controllers\RoomControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequests\UpdateRoomRequest;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomInputPort;
use App\UseCases\RoomUseCases\UpdateRoomUseCase\UpdateRoomRequestModel;
use Illuminate\Http\JsonResponse;

/*
|--------------------------------------------------------------------------
| SIMPLIFIED ADAPTATION OF CA
|--------------------------------------------------------------------------
|
| Thick interactors, a lot of resources.
|
*/

class UpdateRoomController extends Controller
{
    public function __construct(
        private readonly UpdateRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(UpdateRoomRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->updateRoom(
            App()->makeWith(
                UpdateRoomRequestModel::class,
                ['attributes' => $request->validated(), 'id' => $request->route('id'), 'user' => $request->user()]
            )
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
