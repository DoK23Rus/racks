<?php

namespace App\Http\Resources\RackResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToDeleteRackResponse",
 *     title="Unable to delete rack",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to delete rack"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToDeleteRackResource extends JsonResource
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
            'message' => 'Unable to delete rack',
            'error' => $this->e->getMessage(),
        ];
    }
}
