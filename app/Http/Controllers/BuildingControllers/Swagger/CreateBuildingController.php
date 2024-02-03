<?php

namespace App\Http\Controllers\BuildingControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/auth/building",
 *     summary="Create building",
 *     description="Create new building",
 *     operationId="CreateBuilding",
 *     tags={"Building"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\RequestBody(
 *
 *         @OA\JsonContent(
 *             oneOf={
 *
 *                 @OA\Schema(ref="#/components/schemas/CreateBuildingRequest")
 *             }
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Building created",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/CreateBuildingResponse")
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
 *                      @OA\Schema(ref="#/components/schemas/NoSuchSiteForBuildingResponse"),
 *                      @OA\Schema(ref="#/components/schemas/BuildingNameExceptionResponse"),
 *                  }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Unable to create building",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/UnableToCreateBuildingResponse"),
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
class CreateBuildingController extends Controller
{
}
