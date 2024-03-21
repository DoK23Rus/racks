<?php

namespace App\UseCases\SiteUseCases\GetSiteUseCase;

use App\Domain\Interfaces\SiteInterfaces\SiteRepository;
use App\Domain\Interfaces\ViewModel;

class GetSiteInteractor implements GetSiteInputPort
{
    /**
     * @param  GetSiteOutputPort  $output
     * @param  SiteRepository  $siteRepository
     */
    public function __construct(
        private readonly GetSiteOutputPort $output,
        private readonly SiteRepository $siteRepository
    ) {
    }

    /**
     * @param  GetSiteRequestModel  $request
     * @return ViewModel
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function getSite(GetSiteRequestModel $request): ViewModel
    {
        // Try to get site
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
