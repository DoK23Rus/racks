<?php

namespace App\UseCases\DepartmentUseCases\CreateDepartmentUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\RegionInterfaces\RegionFactory;
use App\Domain\Interfaces\RegionInterfaces\RegionRepository;
use App\Domain\Interfaces\ViewModel;

class CreateDepartmentInteractor implements CreateDepartmentInputPort
{
    public function __construct(
        private readonly CreateDepartmentOutputPort $output,
        private readonly DepartmentRepository $departmentRepository,
        private readonly RegionRepository $regionRepository,
        private readonly DepartmentFactory $departmentFactory,
        private readonly RegionFactory $regionFactory
    ) {
    }

    public function createDepartment(CreateDepartmentRequestModel $request): ViewModel
    {
        $department = $this->departmentFactory->makeFromCreateRequest($request);

        $region = $this->regionFactory->makeFromId($request->getRegionId());

        try {
            $region = $this->regionRepository->getById($region->getId());
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
