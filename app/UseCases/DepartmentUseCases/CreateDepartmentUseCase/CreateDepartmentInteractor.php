<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class CreateDepartmentInteractor implements CreateDepartmentInputPort
{
    /**
     * @param  CreateDepartmentOutputPort  $output
     * @param  DepartmentRepository  $departmentRepository
     * @param  RegionRepository  $regionRepository
     * @param  DepartmentFactory  $departmentFactory
     */
    public function __construct(
        private readonly CreateDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository,
        private readonly RegionRepository $regionRepository,
        private readonly DepartmentFactory $departmentFactory
    ) {
    }

    /**
     * @param  CreateDepartmentRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createDepartment(CreateDepartmentRequestModel $request): ViewModel
    {
        $department = $this->departmentFactory->makeFromCreateRequest($request);

        try {
            $region = $this->regionRepository->getById($request->getRegionId());
        } catch (\Exception $e) {
            return $this->output->noSuchRegion(
                App()->makeWith(CreateDepartmentResponseModel::class, ['department' => $department])
            );
        }

        if ($this->departmentRepository->exists($department)) {
            return $this->output->departmentAlreadyExists(
                App()->makeWith(CreateDepartmentResponseModel::class, ['department' => $department])
            );
        }

        try {
            $department = $this->departmentRepository->create($department);
        } catch (\Exception $e) {
            return $this->output->unableToCreateDepartment(
                App()->makeWith(CreateDepartmentResponseModel::class, ['department' => $department]),
                $e
            );
        }

        return $this->output->departmentCreated(
            App()->makeWith(CreateDepartmentResponseModel::class, ['department' => $department])
        );
    }
}
