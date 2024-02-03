<?php

namespace App\Http\Controllers\RackControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/rack/vendors",
 *     summary="Get rack vendors",
 *     description="Get rack vendors list",
 *     operationId="GetRackVendors",
 *     tags={"Rack"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get rack vendors",
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
 *                                  example="rack_vendor",
 *                              ),
 *                         @OA\Property(property="items", type="array",
 *
 *                             @OA\Items(
 *                                 type="string",
 *                                 description="Rack vendor",
 *                             ),
 *                             example={"ITK","ZPAS"}
 *                         ),
 *                     )
 *                 }
 *             )
 *         )
 *     ),
 * )
 */
class GetRackVendorsController extends Controller
{
}
