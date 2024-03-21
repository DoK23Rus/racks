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

/**
 * API Docs: @see \App\Http\Controllers\RoomControllers\Swagger\DeleteRoomController
 */
class DeleteRoomController extends Controller
{
    /**
     * @param  DeleteRoomInputPort  $interactor
     */
    public function __construct(
        private readonly DeleteRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  DeleteRoomRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
