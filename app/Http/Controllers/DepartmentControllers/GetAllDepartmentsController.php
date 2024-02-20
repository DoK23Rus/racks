<?php

namespace App\Http\Controllers\DepartmentControllers;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
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

/**
 * API Docs: @see \App\Http\Controllers\DepartmentControllers\Swagger\GetAllDepartmentsController
 */
class GetAllDepartmentsController extends Controller
{
    /**
     * @param  DepartmentRepository  $departmentRepository
     */
    public function __construct(
        private readonly DepartmentRepository $departmentRepository
    ) {
        $this->middleware('auth:api');
    }

    /**
     * @param  Request  $request
     * @return LengthAwarePaginator
     */
    public function __invoke(Request $request): LengthAwarePaginator
    {
        return $this->departmentRepository->getAll(
            $request->route('per_page')
        );
    }
}
