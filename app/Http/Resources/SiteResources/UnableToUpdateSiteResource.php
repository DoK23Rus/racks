<?php

namespace App\Http\Resources\SiteResources;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UnableToUpdateSiteResponse",
 *     title="Unable to delete site",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Unable to delete site"
 *         ),
 *         @OA\Property(
 *             property="error",
 *             type="string",
 *             example="Some internal error"
 *         )
 *     )
 * )
 */
class UnableToUpdateSiteResource extends JsonResource
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
            'message' => 'Unable to update site',
            'error' => $this->e->getMessage(),
        ];
    }
}
