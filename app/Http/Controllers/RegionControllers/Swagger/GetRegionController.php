<?php

namespace App\Http\Controllers\RegionControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/region/{id}",
 *     summary="Get region",
 *     description="Get region",
 *     operationId="RetrieveRegion",
 *     tags={"Region"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Region ID",
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
 *         description="Get region",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RetrieveRegionResponse")
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such region",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/NoSuchRegionForRegionResponse"),
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetRegionController extends Controller
{
}
