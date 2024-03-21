<?php

namespace App\Http\Resources\SiteResources;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchDepartmentForSiteResponse",
 *     title="No such building",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such building"
 *         )
 *     )
 * )
 */
class NoSuchDepartmentResource extends JsonResource
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
            'message' => 'No such department',
        ];
    }
}
