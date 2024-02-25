<?php

namespace App\Http\Controllers\RoomControllers\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/room/{id}/location",
 *     summary="Get room location",
 *     description="Get room location",
 *     operationId="GetRoomLocation",
 *     tags={"Room"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Room ID",
 *         in="path",
 *         name="id",
 *         required=true,
 *
 *         @OA\Schema(
 *             default=2,
 *             type="integer",
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get room location",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 anyOf={
 *
 *                     @OA\Schema(
 *
 *                         @OA\Property(
 *                             property="region_name",
 *                             type="string",
 *                             example="Some region",
 *                         ),
 *                         @OA\Property(
 *                             property="department_name",
 *                             type="string",
 *                             example="Some department",
 *                         ),
 *                         @OA\Property(
 *                             property="site_name",
 *                             type="string",
 *                             example="Some site",
 *                         ),
 *                         @OA\Property(
 *                             property="building_name",
 *                             type="string",
 *                             example="Some building",
 *                         ),
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such room",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(
 *
 *                         @OA\Property(
 *                              property="message",
 *                              type="string",
 *                              example="No such room"
 *                         )
 *                     )
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetRoomLocationController
{
}
