<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentFactory;
use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateSiteInteractor implements CreateSiteInputPort
{
    public function __construct(
        private readonly CreateSiteOutputPort $output,
        private readonly SiteRepository $siteRepository,
        private readonly DepartmentRepository $departmentRepository,
        private readonly DepartmentFactory $departmentFactory,
        private readonly SiteFactory $siteFactory
    ) {
    }

    public function createSite(CreateSiteRequestModel $request): ViewModel
    {
        $site = $this->siteFactory->makeFromCreateRequest($request);

        $department = $this->departmentFactory->makeFromId($request->getDepartmentId());

        try {
            $department = $this->departmentRepository->getById($department->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(CreateSiteResponseModel::class, ['site' => $site])
            );
        }

        if (! Gate::allows('departmentCheck', $department->getId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateSiteResponseModel::class, ['site' => $site])
            );
        }

        $site->setUpdatedBy($request->getUserName());

        try {
            $site = $this->siteRepository->create($site);
        } catch (\Exception $e) {
            return $this->output->unableToCreateSite(
                App()->makeWith(CreateSiteResponseModel::class, ['site' => $site]),
                $e
            );
        }

        Log::channel('action_log')->info("Create Site --> fk {$department->getId()}", [
            'new_data' => $site->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->siteCreated(
            App()->makeWith(CreateSiteResponseModel::class, ['site' => $site])
        );
    }
}
