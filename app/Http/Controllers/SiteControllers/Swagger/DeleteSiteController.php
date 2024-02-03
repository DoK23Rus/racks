<?php

namespace App\Http\Controllers\SiteControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Delete(
 *     path="/api/auth/site/{id}",
 *     summary="Delete site",
 *     description="Delete site",
 *     operationId="DeleteSite",
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
 *         response=204,
 *         description="Site deleted - No content",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No such site",
 *
 *         @OA\JsonContent(
 *
 *              @OA\Property(property="data", type="object",
 *                  oneOf={
 *
 *                      @OA\Schema(ref="#/components/schemas/NoSuchSiteForSiteResponse"),
 *                  }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Unable to delete site",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/UnableToDeleteSiteResponse"),
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
class DeleteSiteController extends Controller
{
}
