<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;

class GetSiteInteractor implements GetSiteInputPort
{
    public function __construct(
        private readonly GetSiteOutputPort $output,
        private readonly SiteRepository $siteRepository
    ) {
    }

    public function getSite(GetSiteRequestModel $request): ViewModel
    {
        try {
            $site = $this->siteRepository->getById($request->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(GetSiteResponseModel::class, ['site' => null])
            );
        }

        return $this->output->retrieveSite(
            App()->makeWith(GetSiteResponseModel::class, ['site' => $site])
        );
    }
}
