<?php

namespace App\Http\Resources\RegionResources;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RetrieveRegionResponse",
 *     title="Get region",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Region name"
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
class RetrieveRegionResource extends JsonResource
{
    protected RegionEntity $region;

    public function __construct(RegionEntity $region)
    {
        parent::__construct($region);
        $this->region = $region;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->region->getId(),
            'name' => $this->region->getName(),
            'created_at' => $this->region->getCreatedAt(),
            'updated_at' => $this->region->getUpdatedAt(),
        ];
    }
}
