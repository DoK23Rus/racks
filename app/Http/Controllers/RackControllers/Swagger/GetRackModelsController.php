<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/rack/models",
 *     summary="Get rack models",
 *     description="Get rack models list",
 *     operationId="GetRackModels",
 *     tags={"Rack"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get rack models",
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
 *                                  example="rack_model",
 *                              ),
 *                         @OA\Property(property="items", type="array",
 *
 *                             @OA\Items(
 *                                 type="string",
 *                                 description="Rack model",
 *                             ),
 *                             example={"WE-15U","WE-9U"}
 *                         ),
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 * )
 */
class GetRackModelsController extends Controller
{
}
