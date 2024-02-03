<?php

namespace App\Http\Controllers\SiteControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/site/all/{per_page}",
 *     summary="Get all sites",
 *     description="Get all sites paginator",
 *     operationId="GetAllSites",
 *     tags={"Site"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Sites per page",
 *         in="path",
 *         name="per_page",
 *         required=true,
 *
 *         @OA\Schema(
 *            default=10,
 *            type="integer",
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Retrieve site paginator",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(
 *                 property="current_page",
 *                 type="integer",
 *                 example=1,
 *             ),
 *             @OA\Property(property="data", type="array",
 *
 *                 @OA\Items(description="Sites",
 *                     allOf={
 *
 *                         @OA\Schema(ref="#/components/schemas/RetrieveSiteResponse"),
 *                     }
 *                 )
 *             ),
 *
 *             @OA\Property(
 *                 property="first_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/site/all/2?page=1",
 *             ),
 *             @OA\Property(
 *                 property="from",
 *                 type="integer",
 *                 example=1,
 *             ),
 *             @OA\Property(
 *                 property="last_page",
 *                 type="integer",
 *                 example=1,
 *             ),
 *             @OA\Property(
 *                 property="last_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/site/all/2?page=1",
 *             ),
 *             @OA\Property(property="links", type="array",
 *
 *                 @OA\Items(
 *                     anyOf={
 *
 *                          @OA\Schema(ref="#/components/schemas/PaginatorPreviousPage"),
 *                          @OA\Schema(ref="#/components/schemas/PaginatorNumberedPage"),
 *                          @OA\Schema(ref="#/components/schemas/PaginatorNextPage"),
 *
 *                     }
 *                 ),
 *             ),
 *
 *             @OA\Property(
 *                 property="next_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/item/all/2?page=2",
 *             ),
 *             @OA\Property(
 *                 property="path",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/item/all/2",
 *             ),
 *             @OA\Property(
 *                 property="per_page",
 *                 type="integer",
 *                 example=1,
 *             ),
 *             @OA\Property(
 *                 property="prev_page_url",
 *                 type={"string", "null"},
 *                 example=null,
 *             ),
 *             @OA\Property(
 *                 property="to",
 *                 type="integer",
 *                 example=1,
 *             ),
 *             @OA\Property(
 *                 property="total",
 *                 type="integer",
 *                 example=1,
 *             ),
 *         )
 *     ),
 * )
 */
class GetAllSitesController extends Controller
{
}
