<?php

namespace App\Http\Controllers\DeviceControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/device/{id}",
 *     summary="Get device",
 *     description="Get device",
 *     operationId="RetrieveDevice",
 *     tags={"Device"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Device ID",
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
 *         description="Get device",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RetrieveDeviceResponse")
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such device",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/NoSuchDeviceForDeviceResponse"),
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetDeviceController extends Controller
{
}
