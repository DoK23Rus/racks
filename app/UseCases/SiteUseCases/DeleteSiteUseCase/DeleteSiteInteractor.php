<?php

namespace App\UseCases\SiteUseCases\DeleteSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DeleteSiteInteractor implements DeleteSiteInputPort
{
    /**
     * @param  DeleteSiteOutputPort  $output
     * @param  SiteRepository  $siteRepository
     */
    public function __construct(
        private readonly DeleteSiteOutputPort $output,
        private readonly SiteRepository $siteRepository
    ) {
    }

    /**
     * @param  DeleteSiteRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function deleteSite(DeleteSiteRequestModel $request): ViewModel
    {
        try {
            $site = $this->siteRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(DeleteSiteResponseModel::class, ['site' => null])
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
