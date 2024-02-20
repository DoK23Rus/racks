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

/**
 * API Docs: @see \App\Http\Controllers\RoomControllers\Swagger\GetRoomController
 */
class GetRoomController extends Controller
{
    /**
     * @param  GetRoomInputPort  $interactor
     */
    public function __construct(
        private readonly GetRoomInputPort $interactor,
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  GetRoomRequest  $request
     * @return JsonResponse|null
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
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
