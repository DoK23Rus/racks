<?php

namespace App\Http\Controllers\DeviceControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/device/models",
 *     summary="Get device models",
 *     description="Get device models list",
 *     operationId="GetDeviceModels",
 *     tags={"Device"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get device models",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(
 *
 *                         @OA\Property(
 *                                  property="item_type",
 *                                  type="string",
 *                                  example="device_model",
 *                              ),
 *                         @OA\Property(property="items", type="array",
 *
 *                             @OA\Items(
 *                                 type="string",
 *                                 description="Device model",
 *                             ),
 *                             example={"2960","1940","2950"}
 *                         ),
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 * )
 */
class GetDeviceModelsController extends Controller
{
}
