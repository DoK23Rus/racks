<?php

namespace App\Http\Resources\BuildingResources;

use App\Domain\Interfaces\BuildingInterfaces\BuildingEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="BuildingDeletedResponse",
 *     title="Building deleted",
 * )
 */
class BuildingDeletedResource extends JsonResource
{
    protected BuildingEntity $building;

    public function __construct(BuildingEntity $building)
    {
        parent::__construct($building);
        $this->building = $building;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'No content 204',
        ];
    }
}
