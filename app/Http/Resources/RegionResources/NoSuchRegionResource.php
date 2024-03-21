<?php

namespace App\Http\Resources\RegionResources;

use App\Domain\Interfaces\RegionInterfaces\RegionEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchRegionForRegionResponse",
 *     title="No such region",
 *
 *         @OA\Property(
 *              property="message",
 *              type="string",
 *              example="No such region"
 *         )
 *     )
 * )
 */
class NoSuchRegionResource extends JsonResource
{
    /**
     * @var RegionEntity|null
     */
    protected ?RegionEntity $region;

    /**
     * @param  RegionEntity|null  $region
     */
    public function __construct(?RegionEntity $region)
    {
        parent::__construct($region);
        $this->region = $region;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'No such region',
        ];
    }
}
