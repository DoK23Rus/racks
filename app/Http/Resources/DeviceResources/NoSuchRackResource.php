<?php

namespace App\Http\Resources\DeviceResources;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchRackForDeviceResponse",
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
     * @var DeviceEntity
     */
    protected DeviceEntity $device;

    /**
     * @param  DeviceEntity  $device
     */
    public function __construct(DeviceEntity $device)
    {
        parent::__construct($device);
        $this->device = $device;
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
