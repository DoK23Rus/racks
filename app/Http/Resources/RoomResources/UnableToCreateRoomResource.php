<?php

namespace App\Http\Resources\RoomResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToCreateRoomResponse",
 *     title="Unable to create room",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to create room"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToCreateRoomResource extends JsonResource
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
            'message' => 'Unable to create room',
            'error' => $this->e->getMessage(),
        ];
    }
}
