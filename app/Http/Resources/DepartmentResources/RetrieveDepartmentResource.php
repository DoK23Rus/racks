<?php

namespace App\Http\Resources\DepartmentResources;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RetrieveDepartmentResponse",
 *     title="Get department",
 *
 * 	   @OA\Property(
 * 		   property="id",
 * 		   type="integer",
 *         example=1
 * 	   ),
 * 	   @OA\Property(
 * 		   property="name",
 * 		   type="string",
 *         example="Department name"
 * 	   ),
 *     @OA\Property(
 *         property="region_id",
 *         type="integer",
 *         example=1
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
class RetrieveDepartmentResource extends JsonResource
{
    protected DepartmentEntity $department;

    public function __construct(DepartmentEntity $department)
    {
        parent::__construct($department);
        $this->department = $department;
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->department->getId(),
            'name' => $this->department->getName(),
            'region_id' => $this->department->getRegionId(),
            'created_at' => $this->department->getCreatedAt(),
            'updated_at' => $this->department->getUpdatedAt(),
        ];
    }
}
