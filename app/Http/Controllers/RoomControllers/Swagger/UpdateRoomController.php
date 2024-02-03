<?php

namespace App\Http\Controllers\RoomControllers\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Patch(
 *     path="/api/auth/room/{id}",
 *     summary="Update room",
 *     description="Update room",
 *     operationId="UpdateRoom",
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
 *     @OA\RequestBody(
 *
 *         @OA\JsonContent(
 *             oneOf={
 *
 *                 @OA\Schema(ref="#/components/schemas/UpdateRoomRequest")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=202,
 *         description="Room updated",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RoomUpdatedResponse")
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
 *              @OA\Property(property="data", type="object",
 *                  oneOf={
 *
 *                      @OA\Schema(ref="#/components/schemas/NoSuchRoomForRoomResponse"),
 *                  }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Room with this name already exists in this building",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RoomNameExceptionResponse"),
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Action not allowed for this department",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/PermissionExceptionResponse"),
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Unable to update room",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/UnableToCreateRoomResponse"),
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class UpdateRoomController
{
}
