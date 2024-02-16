<?php

namespace App\Http\Resources\RoomResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToUpdateRoomResponse",
 *     title="Unable to delete room",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to delete room"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToUpdateRoomResource extends JsonResource
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
     * @return array<mixed>
     */
    public function toArray($request): array
    {
        return [
            'message' => 'Unable to delete room',
            'error' => $this->e->getMessage(),
        ];
    }
}
