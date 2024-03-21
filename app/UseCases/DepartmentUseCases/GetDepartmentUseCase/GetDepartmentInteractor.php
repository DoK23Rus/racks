<?php

namespace App\UseCases\DepartmentUseCases\GetDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;

class GetDepartmentInteractor implements GetDepartmentInputPort
{
    /**
     * @param  GetDepartmentOutputPort  $output
     * @param  DepartmentRepository  $departmentRepository
     */
    public function __construct(
        private readonly GetDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository
    ) {
    }

    /**
     * @param  GetDepartmentRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getDepartment(GetDepartmentRequestModel $request): ViewModel
    {
        // Try to get department
        try {
            $department = $this->departmentRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(GetDepartmentResponseModel::class, ['department' => null])
            );
        }

        return $this->output->retrieveDepartment(
            App()->makeWith(GetDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
