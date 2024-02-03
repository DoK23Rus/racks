<?php

namespace App\Http\Controllers\DepartmentControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/department/{id}",
 *     summary="Get department",
 *     description="Get department",
 *     operationId="RetrieveDepartment",
 *     tags={"Department"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Parameter(
 *         description="Department ID",
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
 *         description="Get department",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/RetrieveDepartmentResponse")
 *                 }
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="No such department",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="object",
 *                 oneOf={
 *
 *                     @OA\Schema(ref="#/components/schemas/NoSuchDepartmentForDepartmentResponse"),
 *                 }
 *             )
 *         )
 *     )
 * )
 */
class GetDepartmentController extends Controller
{
}
