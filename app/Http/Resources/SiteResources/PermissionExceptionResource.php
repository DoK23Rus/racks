<?php

namespace App\Http\Resources\SiteResources;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionExceptionResource extends JsonResource
{
    /**
     * @var SiteEntity
     */
    protected SiteEntity $site;

    /**
     * @param  SiteEntity  $site
     */
    public function __construct(SiteEntity $site)
    {
        parent::__construct($site);
        $this->site = $site;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Action not allowed for this department',
        ];
    }
}
