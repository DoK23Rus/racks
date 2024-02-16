<?php

namespace App\Http\Resources\DepartmentResources;

use App\Domain\Interfaces\DepartmentInterfaces\DepartmentEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchDepartmentForDepartmentResponse",
 *     title="No such department",
 *
 *         @OA\Property(
 *              property="message",
 *              type="string",
 *              example="No such department"
 *         )
 *     )
 * )
 */
class NoSuchDepartmentResource extends JsonResource
{
    protected ?DepartmentEntity $department;

    public function __construct(?DepartmentEntity $department)
    {
        parent::__construct($department);
        $this->department = $department;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'No such department',
        ];
    }
}
