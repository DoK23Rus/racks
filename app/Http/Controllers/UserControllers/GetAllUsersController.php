<?php

namespace App\Http\Controllers\UserControllers;

use App\Domain\Interfaces\UserInterfaces\UserRepository;
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

class GetAllUsersController extends Controller
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
        $this->middleware('auth:api');
    }

    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->userRepository->getAll(
            $request->route('per_page')
        );
    }
}
