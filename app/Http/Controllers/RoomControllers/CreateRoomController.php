<?php

namespace App\Http\Controllers\RoomControllers;

use App\Adapters\ViewModels\JsonResourceViewModel;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequests\CreateRoomRequest;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomInputPort;
use App\UseCases\RoomUseCases\CreateRoomUseCase\CreateRoomRequestModel;
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
 * API Docs: @see \App\Http\Controllers\RoomControllers\Swagger\CreateRoomController
 */
class CreateRoomController extends Controller
{
    /**
     * @param  CreateRoomInputPort  $interactor
     */
    public function __construct(
        private readonly CreateRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  CreateRoomRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __invoke(CreateRoomRequest $request): ?JsonResponse
    {
        $viewModel = $this->interactor->createRoom(
            App()->makeWith(CreateRoomRequestModel::class,
                ['attributes' => $request->validated(), 'user' => $request->user()])
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
