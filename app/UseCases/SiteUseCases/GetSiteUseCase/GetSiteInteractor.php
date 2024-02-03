<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;

class GetSiteInteractor implements GetSiteInputPort
{
    public function __construct(
        private readonly GetSiteOutputPort $output,
        private readonly SiteRepository $siteRepository,
        private readonly SiteFactory $siteFactory
    ) {
    }

    public function getSite(GetSiteRequestModel $request): ViewModel
    {
        $site = $this->siteFactory->makeFromId($request->getId());

        try {
            $site = $this->siteRepository->getById($site->getId());
        } catch (\Exception $e) {
            return $this->output->noSuchSite(
                App()->makeWith(GetSiteResponseModel::class, ['site' => $site])
            );
        }

        return $this->output->retrieveSite(
            App()->makeWith(GetSiteResponseModel::class, ['site' => $site])
        );
    }
}
