<?php

namespace App\Http\Controllers\BuildingControllers\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/building/{id}/location",
 *     summary="Get building location",
 *     description="Get building location",
 *     operationId="GetBuildingLocation",
 *     tags={"Building"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Building ID",
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
 *         description="Get building location",
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
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such building",
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
 *                              example="No such building"
 *                         )
 *                     )
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetBuildingLocationController
{
}
