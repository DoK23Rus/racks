<?php

namespace App\Http\Resources\DeviceResources;

use App\Domain\Interfaces\DeviceInterfaces\DeviceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionExceptionResource extends JsonResource
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
            'message' => 'Action not allowed for this department',
        ];
    }
}
