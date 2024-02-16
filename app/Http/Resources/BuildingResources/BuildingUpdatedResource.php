<?php

namespace App\Http\Resources\BuildingResources;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="BuildingUpdatedResponse",
 *     title="Update building",
 *
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Building name"
 *     ),
 *     @OA\Property(
 *         property="site_id",
 *         type="integer",
 *         example=1
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
class BuildingUpdatedResource extends JsonResource
{
    protected BuildingEntity $building;

    public function __construct(BuildingEntity $building)
    {
        parent::__construct($building);
        $this->building = $building;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->building->getId(),
            'name' => $this->building->getName(),
            'site_id' => $this->building->getSiteId(),
            'department_id' => $this->building->getDepartmentId(),
            'created_at' => $this->building->getCreatedAt(),
            'updated_at' => $this->building->getUpdatedAt(),
        ];
    }
}
