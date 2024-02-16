<?php

namespace App\Http\Resources\RackResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToCreateRackResponse",
 *     title="Unable to create rack",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to create rack"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToCreateRackResource extends JsonResource
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
            'message' => 'Unable to create rack',
            'error' => $this->e->getMessage(),
        ];
    }
}
