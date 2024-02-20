<?php

namespace App\Http\Resources\RackResources;

use App\Domain\Interfaces\RackInterfaces\RackEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RackNameExceptionResponse",
 *     title="Rack with this name already exists in this room",
 *
 *         @OA\Property(
 *              property="message",
 *              type="string",
 *              example="Rack with this name already exists in this room"
 *         )
 *     )
 * )
 */
class RackNameExceptionResource extends JsonResource
{
    /**
     * @var RackEntity
     */
    protected RackEntity $rack;

    /**
     * @param  RackEntity  $rack
     */
    public function __construct(RackEntity $rack)
    {
        parent::__construct($rack);
        $this->rack = $rack;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Rack with this name already exists in this room',
        ];
    }
}
