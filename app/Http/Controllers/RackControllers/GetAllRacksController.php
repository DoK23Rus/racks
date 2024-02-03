<?php

namespace App\Http\Controllers\RackControllers;

use App\Domain\Interfaces\RackInterfaces\RackRepository;
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

class GetAllRacksController extends Controller
{
    public function __construct(
        private readonly RackRepository $rackRepository
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->rackRepository->getAll(
            $request->route('per_page'),
            ['id', 'name', 'updated_by', 'department_id', 'created_at', 'updated_at', 'room_id']
        );
    }
}
