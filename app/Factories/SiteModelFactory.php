<?php

namespace App\Factories;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use App\Domain\Interfaces\SiteInterfaces\SiteFactory;
use App\Models\Site;
use App\UseCases\SiteUseCases\CreateSiteUseCase\CreateSiteRequestModel;
use App\UseCases\SiteUseCases\UpdateSiteUseCase\UpdateSiteRequestModel;

class SiteModelFactory implements SiteFactory
{
    public function makeFromId(int $id): SiteEntity
    {
        return new Site([
            'id' => $id,
        ]);
    }

    public function makeFromCreateRequest(CreateSiteRequestModel $request): SiteEntity
    {
        return new Site([
            'name' => $request->getName(),
            'department_id' => $request->getDepartmentId(),
        ]);
    }

    public function makeFromPutRequest(UpdateSiteRequestModel $request): SiteEntity
    {
        return new Site([
            'id' => $request->getId(),
            'name' => $request->getName(),
        ]);
    }
}
