<?php

namespace App\Http\Resources\SiteResources;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RetrieveSiteResponse",
 *     title="Get site",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Site name"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Some info about site"
 *     ),
 *     @OA\Property(
 *         property="department_id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="updated_by",
 *         type="string",
 *         example="Some user"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         example="2024-01-28 16:32:21"
 *     )
 * )
 */
class RetrieveSiteResource extends JsonResource
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
            'id' => $this->site->getId(),
            'name' => $this->site->getName(),
            'description' => $this->site->getDescription(),
            'department_id' => $this->site->getDepartmentId(),
            'updated_by' => $this->site->getUpdatedBy(),
            'created_at' => $this->site->getCreatedAt(),
            'updated_at' => $this->site->getUpdatedAt(),
        ];
    }
}
