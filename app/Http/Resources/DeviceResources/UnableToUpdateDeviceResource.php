<?php

namespace App\Http\Resources\DeviceResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToUpdateDeviceResponse",
 *     title="Unable to delete device",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to update device"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToUpdateDeviceResource extends JsonResource
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
            'message' => 'Unable to update device',
            'error' => $this->e->getMessage(),
        ];
    }
}
