<?php

namespace App\Http\Resources\RackResources;

use App\Domain\Interfaces\RackInterfaces\RackEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionExceptionResource extends JsonResource
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
            'message' => 'Action not allowed for this department',
        ];
    }
}
