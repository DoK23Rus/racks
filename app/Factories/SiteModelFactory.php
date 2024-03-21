<?php

namespace App\Factories;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Models\Site;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteRequestModel;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteRequestModel;

class SiteModelFactory implements SiteFactory
{
    /**
     * @param  CreateSiteRequestModel  $request
     * @return SiteEntity
     */
    public function makeFromCreateRequest(CreateSiteRequestModel $request): SiteEntity
    {
        return new Site([
            'name' => $request->getName(),
            'description' => $request->getDescription(),
            'department_id' => $request->getDepartmentId(),
        ]);
    }

    /**
     * @param  UpdateSiteRequestModel  $request
     * @return SiteEntity
     */
    public function makeFromPatchRequest(UpdateSiteRequestModel $request): SiteEntity
    {
        return new Site([
            'id' => $request->getId(),
            'name' => $request->getName(),
            'description' => $request->getDescription(),
            'department_id' => $request->getDepartmentId(),
        ]);
    }
}
