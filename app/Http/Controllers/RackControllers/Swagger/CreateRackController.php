<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/auth/rack",
 *     summary="Create rack",
 *     description="Create new rack",
 *     operationId="CreateRack",
 *     tags={"Rack"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *
 *         @OA\JsonContent(
 *             oneOf={
 *
 *                 @OA\Schema(ref="#/components/schemas/CreateRackRequest")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Rack created",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RackCreatedResponse")
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
 *                      @OA\Schema(ref="#/components/schemas/NoSuchRoomForRackResponse"),
 *                      @OA\Schema(ref="#/components/schemas/RackNameExceptionResponse"),
 *                  }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Internal server error",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/UnableToCreateRackResponse"),
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
class CreateRackController extends Controller
{
}
