<?php

namespace App\Http\Controllers\RoomControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/room/all/{per_page}",
 *     summary="Get all rooms",
 *     description="Get all rooms paginator",
 *     operationId="GetAllRooms",
 *     tags={"Room"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Rooms per page",
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
 *         description="Retrieve room paginator",
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
 *                 @OA\Items(description="Rooms",
 *                     allOf={
 *
 *                         @OA\Schema(ref="#/components/schemas/RetrieveRoomResponse"),
 *                     }
 *                 )
 *             ),
 *
 *             @OA\Property(
 *                 property="first_page_url",
 *                 type="string",
 *                 example="http://sitename.domain/api/auth/room/all/2?page=1",
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
 *                 example="http://sitename.domain/api/auth/room/all/2?page=1",
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
class GetAllRoomsController extends Controller
{
}
