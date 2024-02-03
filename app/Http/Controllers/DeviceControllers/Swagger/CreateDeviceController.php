<?php

namespace App\Http\Controllers\DeviceControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/auth/device",
 *     summary="Create device",
 *     description="Create new device",
 *     operationId="CreateDevice",
 *     tags={"Device"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *
 *         @OA\JsonContent(
 *             oneOf={
 *
 *                 @OA\Schema(ref="#/components/schemas/CreateDeviceRequest")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Device created",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/DeviceCreatedResponse")
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
 *                      @OA\Schema(ref="#/components/schemas/NoSuchRackForDeviceResponse"),
 *                      @OA\Schema(ref="#/components/schemas/NoSuchUnitsResponse"),
 *                      @OA\Schema(ref="#/components/schemas/UnitsAreBusyResponse"),
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
 *                     @OA\Schema(ref="#/components/schemas/UnableToCreateDeviceResponse"),
 *                     @OA\Schema(ref="#/components/schemas/DeviceCreationFailedResponse"),
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
class CreateDeviceController extends Controller
{
}
