<?php

namespace App\Http\Resources\DeviceResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="DeviceUpdateFailedResponse",
 *     title="Device update failed",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Device update failed"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class DeviceUpdateFailedResource extends JsonResource
{
    /**
     * @var \Throwable
     */
    protected \Throwable $e;

    /**
     * @param  \Throwable  $e
     */
    public function __construct(\Throwable $e)
    {
        parent::__construct($e);
        $this->e = $e;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Device update failed',
            'error' => $this->e->getMessage(),
        ];
    }
}
