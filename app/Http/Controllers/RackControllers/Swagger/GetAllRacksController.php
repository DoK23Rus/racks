<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/rack/all/{per_page}",
 *     summary="Get all racks",
 *     description="Get all racks paginator",
 *     operationId="GetAllRacks",
 *     tags={"Rack"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Racks per page",
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
 *         description="Retrieve racks paginator",
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
 *                 @OA\Items(description="Racks",
 *                     allOf={
 *
 *                         @OA\Schema(
 *
 *                         	   @OA\Property(
 *                                 property="id",
 *                                 type="integer",
 *                                example=1
 *                             ),
 *                         	   @OA\Property(
 *                                 property="name",
 *                                 type="string",
 *                                 example="Rack name"
 *                             ),
 *                             @OA\Property(
 *                                 property="room_id",
 *                                 type="integer",
 *                                 example=1
 *                             ),
 *                             @OA\Property(
 *                                 property="department_id",
 *                                 type="integer",
 *                                 example=1
 *                             ),
 *                             @OA\Property(
 *                                 property="updated_by",
 *                                 type="string",
 *                                 example="Some user"
 *                             ),
 *                             @OA\Property(
 *                                 property="created_at",
 *                                 type="string",
 *                                 example="2024-01-28 16:32:21"
 *                             ),
 *                             @OA\Property(
 *                                 property="updated_at",
 *                                 type="string",
 *                                 example="2024-01-28 16:32:21"
 *                             )
 *                         )
 *                     }
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="first_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/rack/all/2?page=1",
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
 *                 example="http://sitename.domain/api/auth/rack/all/2?page=1",
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
class GetAllRacksController extends Controller
{
}
