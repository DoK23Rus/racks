<?php

namespace App\UseCases\SiteUseCases\CreateSiteUseCase;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentRepository;
use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CreateSiteInteractor implements CreateSiteInputPort
{
    /**
     * @param  CreateSiteOutputPort  $output
     * @param  SiteRepository  $siteRepository
     * @param  DepartmentRepository  $departmentRepository
     * @param  SiteFactory  $siteFactory
     */
    public function __construct(
        private readonly CreateSiteOutputPort $output,
        private readonly SiteRepository $siteRepository,
        private readonly DepartmentRepository $departmentRepository,
        private readonly SiteFactory $siteFactory
    ) {
    }

    /**
     * @param  CreateSiteRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function createSite(CreateSiteRequestModel $request): ViewModel
    {
        $site = $this->siteFactory->makeFromCreateRequest($request);

        // Try to get department
        try {
            $department = $this->departmentRepository->getById($request->getDepartmentId());
        } catch (\Exception $e) {
            return $this->output->noSuchDepartment(
                App()->makeWith(CreateSiteResponseModel::class, ['site' => $site])
            );
        }

        // User department check
        if (! Gate::allows('departmentCheck', $department->getId())) {
            return $this->output->permissionException(
                App()->makeWith(CreateSiteResponseModel::class, ['site' => $site])
            );
        }

        $site->setUpdatedBy($request->getUserName());

        // Try to create
        try {
            $site = $this->siteRepository->create($site);

            $site = $site->fresh([]);
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
