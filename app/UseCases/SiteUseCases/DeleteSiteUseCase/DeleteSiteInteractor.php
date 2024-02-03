<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteSiteInteractor implements DeleteSiteInputPort
{
    public function __construct(
        private readonly DeleteSiteOutputPort $output,
        private readonly SiteRepository $siteRepository,
        private readonly SiteFactory $siteFactory
    ) {
    }

    public function deleteSite(DeleteSiteRequestModel $request): ViewModel
    {
        $site = $this->siteFactory->makeFromId($request->getId());

        try {
            $site = $this->siteRepository->getById($site->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(DeleteSiteResponseModel::class, ['site' => $site])
            );
        }

        if (! Gate::allows('departmentCheck', $site->getDepartmentId())) {
            return $this->output->permissionException(
                App()->makeWith(DeleteSiteResponseModel::class, ['site' => $site])
            );
        }

        try {
            $this->siteRepository->delete($site);
        } catch (\Exception $e) {
            return $this->output->unableToDeleteSite(
                App()->makeWith(DeleteSiteResponseModel::class, ['site' => $site]),
                $e
            );
        }

        Log::channel('action_log')->info("Delete Site --> pk {$site->getId()}", [
            'deleted_data' => $site->toArray(),
            'by_user' => $request->getUserName(),
        ]);

        return $this->output->siteDeleted(
            App()->makeWith(DeleteSiteResponseModel::class, ['site' => $site])
        );
    }
}
