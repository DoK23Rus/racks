<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/rack/{id}/location",
 *     summary="Get rack location",
 *     description="Get rack location",
 *     operationId="GetRackLocation",
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
 *         description="Get rack location",
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
 *                     )
 *                 }
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
class GetRackLocationController extends Controller
{
}
