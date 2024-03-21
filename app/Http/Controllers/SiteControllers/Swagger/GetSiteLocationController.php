<?php

namespace App\Http\Controllers\SiteControllers\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/site/{id}/location",
 *     summary="Get site location",
 *     description="Get site location",
 *     operationId="GetSiteLocation",
 *     tags={"Site"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Site ID",
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
 *         description="Get site location",
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
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such site",
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
 *                              example="No such site"
 *                         )
 *                     )
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetSiteLocationController
{
}
