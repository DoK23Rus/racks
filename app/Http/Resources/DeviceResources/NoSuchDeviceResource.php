<?php

namespace App\Http\Resources\DeviceResources;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchDeviceForDeviceResponse",
 *     title="No such device",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such device"
 *         )
 *     )
 * )
 */
class NoSuchDeviceResource extends JsonResource
{
    protected ?DeviceEntity $device;

    public function __construct(?DeviceEntity $device)
    {
        parent::__construct($device);
        $this->device = $device;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'No such device',
        ];
    }
}
