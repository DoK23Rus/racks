<?php

namespace App\Http\Resources\DeviceResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="DeviceDeletionFailedResponse",
 *     title="Device creation failed",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Device deletion failed"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class DeviceDeletionFailedResource extends JsonResource
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
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'Device deletion failed',
            'error' => $this->e->getMessage(),
        ];
    }
}
