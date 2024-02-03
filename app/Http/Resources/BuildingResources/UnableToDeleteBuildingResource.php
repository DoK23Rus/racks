<?php

namespace App\Http\Resources\BuildingResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToDeleteBuildingResponse",
 *     title="Unable to delete building",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to delete building"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToDeleteBuildingResource extends JsonResource
{
    protected \Throwable $e;

    public function __construct(\Throwable $e)
    {
        parent::__construct($e);
        $this->e = $e;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'message' => 'Unable to delete building',
            'error' => $this->e->getMessage(),
        ];
    }
}
