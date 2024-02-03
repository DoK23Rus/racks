<?php

namespace App\Http\Controllers\RegionControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/region/all/{per_page}",
 *     summary="Get all regions",
 *     description="Get all regions paginator",
 *     operationId="GetAllRegions",
 *     tags={"Region"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Regions per page",
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
 *         description="Retrieve regions paginator",
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
 *                 @OA\Items(description="Regions",
 *                     allOf={
 *
 *                         @OA\Schema(ref="#/components/schemas/RetrieveRegionResponse"),
 *                     }
 *                 )
 *             ),
 *
 *             @OA\Property(
 *                 property="first_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/region/all/2?page=1",
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
 *                 example="http://sitename.domain/api/auth/region/all/2?page=1",
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
class GetAllRegionsController extends Controller
{
}
