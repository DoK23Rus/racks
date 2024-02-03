<?php

namespace App\Http\Controllers\DeviceControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/device/{id}/location",
 *     summary="Get device location",
 *     description="Get device location",
 *     operationId="GetDeviceLocation",
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
 *         description="Get device location",
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
 *                         @OA\Property(
 *                             property="room_name",
 *                             type="string",
 *                            example="Some room",
 *                         ),
 *                         @OA\Property(
 *                             property="rack_name",
 *                             type="string",
 *                             example="Some rack",
 *                         ),
 *                     )
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
 *                     @OA\Schema(
 *
 *                         @OA\Property(
 *                              property="message",
 *                              type="string",
 *                              example="No such device"
 *                         )
 *                     )
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetDeviceLocationController extends Controller
{
}
