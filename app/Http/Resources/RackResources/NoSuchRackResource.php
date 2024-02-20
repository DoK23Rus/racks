<?php

namespace App\Http\Resources\RackResources;

use App\Domain\Interfaces\RackInterfaces\RackEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchRackForRackResponse",
 *     title="No such rack",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such rack"
 *         )
 *     )
 * )
 */
class NoSuchRackResource extends JsonResource
{
    /**
     * @var RackEntity|null
     */
    protected ?RackEntity $rack;

    /**
     * @param  RackEntity|null  $rack
     */
    public function __construct(?RackEntity $rack)
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
            'message' => 'No such rack',
        ];
    }
}
