<?php

namespace App\Http\Controllers\RoomControllers;

use App\Domain\Interfaces\RoomInterfaces\RoomRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/*
|--------------------------------------------------------------------------
| RAPID APPROACH
|--------------------------------------------------------------------------
|
| Not much business logic, not likely to change.
|
*/

class GetAllRoomsController extends Controller
{
    public function __construct(
        private readonly RoomRepository $roomRepository
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->roomRepository->getAll(
            $request->route('per_page')
        );
    }
}
