<?php

namespace App\UseCases\DepartmentUseCases\UpdateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\ViewModel;

class UpdateDepartmentInteractor implements UpdateDepartmentInputPort
{
    /**
     * @param  UpdateDepartmentOutputPort  $output
     * @param  DepartmentRepository  $departmentRepository
     * @param  DepartmentFactory  $departmentFactory
     */
    public function __construct(
        private readonly UpdateDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository,
        private readonly DepartmentFactory $departmentFactory,
    ) {
    }

    /**
     * @param  UpdateDepartmentRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function updateDepartment(UpdateDepartmentRequestModel $request): ViewModel
    {
        $departmentUpdating = $this->departmentFactory->makeFromPatchRequest($request);

        try {
            $department = $this->departmentRepository->getById($departmentUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(UpdateDepartmentResponseModel::class, ['department' => $departmentUpdating])
            );
        }

        try {
            $department = $this->departmentRepository->update($departmentUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateDepartment(
                App()->makeWith(UpdateDepartmentResponseModel::class, ['department' => $departmentUpdating]),
                $e
            );
        }

        return $this->output->departmentUpdated(
            App()->makeWith(UpdateDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
