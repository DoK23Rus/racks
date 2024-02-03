<?php

namespace App\Http\Controllers\BuildingControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/building/all/{per_page}",
 *     summary="Get all buildings",
 *     description="Get all buildings paginator",
 *     operationId="GetAllBuildings",
 *     tags={"Building"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Buildings per page",
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
 *         description="Retrieve buildings paginator",
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
 *                 @OA\Items(description="Buildings",
 *                     allOf={
 *
 *                         @OA\Schema(ref="#/components/schemas/RetrieveBuildingResponse"),
 *                     }
 *                 )
 *             ),
 *
 *             @OA\Property(
 *                 property="first_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/building/all/2?page=1",
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
 *                 example="http://sitename.domain/api/auth/building/all/2?page=1",
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
class GetAllBuildingsController extends Controller
{
}
