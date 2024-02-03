<?php

namespace App\Http\Controllers\RoomControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/auth/room",
 *     summary="Create room",
 *     description="Create new room",
 *     operationId="CreateRoom",
 *     tags={"Room"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *
 *         @OA\JsonContent(
 *             oneOf={
 *
 *                 @OA\Schema(ref="#/components/schemas/CreateRoomRequest")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Room created",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/CreateRoomResponse")
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=400,
 *         description="Bad request",
 *
 *         @OA\JsonContent(
 *
 *              @OA\Property(property="data", type="object",
 *                  oneOf={
 *
 *                      @OA\Schema(ref="#/components/schemas/NoSuchBuildingForRoomResponse"),
 *                      @OA\Schema(ref="#/components/schemas/RoomNameExceptionResponse"),
 *                  }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Unable to create room",
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
 *     )
 * )
 */
class CreateRoomController extends Controller
{
}
