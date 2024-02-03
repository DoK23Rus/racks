<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/rack/{id}/devices",
 *     summary="Get rack devices",
 *     description="Get rack devices",
 *     operationId="GetRackDevices",
 *     tags={"Rack"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Rack ID",
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
 *         description="Get rack devices",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="array",
 *
 *                 @OA\Items(description="Devices",
 *                     allOf={
 *
 *                         @OA\Schema(ref="#/components/schemas/RetrieveDeviceResponse")
 *                     }
 *                 )
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such rack",
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
 *                              example="No such rack"
 *                         )
 *                     )
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetRackDevicesController extends Controller
{
}
