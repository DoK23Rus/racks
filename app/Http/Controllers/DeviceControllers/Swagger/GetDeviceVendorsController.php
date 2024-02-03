<?php

namespace App\Http\Controllers\DeviceControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/device/vendors",
 *     summary="Get device vendors",
 *     description="Get device vendors list",
 *     operationId="GetDeviceVendors",
 *     tags={"Device"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get device vendors",
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
 *                                  example="device_vendor",
 *                              ),
 *                         @OA\Property(property="items", type="array",
 *
 *                             @OA\Items(
 *                                 type="string",
 *                                 description="Device vendor",
 *                             ),
 *                             example={"Cisco","Huawei","HP"}
 *                         ),
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 * )
 */
class GetDeviceVendorsController extends Controller
{
}
