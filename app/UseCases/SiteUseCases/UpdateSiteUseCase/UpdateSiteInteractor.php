<?php

namespace App\UseCases\SiteUseCases\UpdateSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UpdateSiteInteractor implements UpdateSiteInputPort
{
    public function __construct(
        private readonly UpdateSiteOutputPort $output,
        private readonly SiteRepository $siteRepository,
        private readonly SiteFactory $siteFactory
    ) {
    }

    public function updateSite(UpdateSiteRequestModel $request): ViewModel
    {
        $siteUpdating = $this->siteFactory->makeFromPatchRequest($request);

        try {
            $site = $this->siteRepository->getById($siteUpdating->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(UpdateSiteResponseModel::class, ['site' => $siteUpdating])
            );
        }

        if (! Gate::allows('departmentCheck', $site->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(UpdateSiteResponseModel::class, ['site' => $siteUpdating])
            );
        }

        $siteUpdating->setUpdatedBy($request->getUserName());

        try {
            $siteUpdating = $this->siteRepository->update($siteUpdating);
        } catch (\Exception $e) {
            return $this->output->unableToUpdateSite(
                App()->makeWith(UpdateSiteResponseModel::class, ['site' => $siteUpdating]),
                $e
            );
        }

        Log::channel('action_log')->info("Update Site {$site->getId()}", [
            'old_data' => $site->toArray(),
            'new_data' => $siteUpdating->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->siteUpdated(
            App()->makeWith(UpdateSiteResponseModel::class, ['site' => $siteUpdating])
        );
    }
}
