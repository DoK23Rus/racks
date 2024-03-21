<?php

namespace App\Http\Resources\SiteResources;

use App\Domain\Interfaces\SiteInterfaces\SiteEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="NoSuchSiteForSiteResponse",
 *     title="No such site",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="No such site"
 *         )
 *     )
 * )
 */
class NoSuchSiteResource extends JsonResource
{
    /**
     * @var SiteEntity|null
     */
    protected ?SiteEntity $site;

    /**
     * @param  SiteEntity|null  $site
     */
    public function __construct(?SiteEntity $site)
    {
        parent::__construct($site);
        $this->site = $site;
    }

    /**
     * @param  Request  $request
     * @return array<mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => 'No such site',
        ];
    }
}
