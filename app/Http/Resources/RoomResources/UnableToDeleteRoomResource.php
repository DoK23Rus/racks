<?php

namespace App\Http\Resources\RoomResources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToDeleteRoomResponse",
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
class UnableToDeleteRoomResource extends JsonResource
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
            'message' => 'Unable to delete room',
            'error' => $this->e->getMessage(),
        ];
    }
}
