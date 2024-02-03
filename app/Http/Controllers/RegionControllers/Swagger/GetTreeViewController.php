<?php

namespace App\Http\Controllers\RegionControllers\Swagger;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/auth/tree",
 *     summary="Get tree view",
 *     description="Get tree view",
 *     operationId="GetTreeView",
 *     tags={"Region"},
 *     security={{ "bearerAuth": {} }},
 *
 *     @OA\Response(
 *         response=200,
 *         description="Get tree view",
 *
 *         @OA\JsonContent(
 *
 *             @OA\Property(property="data", type="array",
 *
 *                 @OA\Items(allOf={ @OA\Schema(
 *
 *                     @OA\Property(property="id", type="integer", example=1),
 *  	               @OA\Property(property="region_name", type="string", example="Region name"),
 *                     @OA\Property(property="children", type="array",
 *
 *                         @OA\Items(allOf={ @OA\Schema(
 *
 *                             @OA\Property(property="id", type="integer", example=1),
 *   	                       @OA\Property(property="department_name", type="string", example="Department name"),
 *                             @OA\Property(property="region_id", type="integer", example=1),
 *                             @OA\Property(property="children", type="array",
 *
 *                                 @OA\Items(allOf={ @OA\Schema(
 *
 *                                     @OA\Property(property="id", type="integer", example=1),
 *    	                               @OA\Property(property="site_name", type="string", example="Site name"),
 *                                     @OA\Property(property="department_id", type="integer", example=1),
 *                                     @OA\Property(property="children", type="array",
 *
 *                                         @OA\Items(allOf={ @OA\Schema(
 *
 *                                             @OA\Property(property="id", type="integer", example=1),
 *     	                                       @OA\Property(property="building_name", type="string", example="Building name"),
 *                                             @OA\Property(property="site_id", type="integer", example=1),
 *                                             @OA\Property(property="children", type="array",
 *
 *                                                 @OA\Items(allOf={ @OA\Schema(
 *
 *                                                     @OA\Property(property="id", type="integer", example=1),
 *      	                                           @OA\Property(property="room_name", type="string", example="Room name"),
 *                                                     @OA\Property(property="building_id", type="integer", example=1),
 *                                                     @OA\Property(property="children", type="array",
 *
 *                                                         @OA\Items(allOf={ @OA\Schema(
 *
 *                                                             @OA\Property(property="id", type="integer", example=1),
 *       	                                                   @OA\Property(property="rack_name", type="string", example="Rack name"),
 *                                                             @OA\Property(property="room_id", type="integer", example=1),
 *                                                         )}),
 *                                                 ))}),
 *                                         ))}),
 *                                 ))}),
 *                         ))}),
 *                 ))}),
 *             )
 *         )
 *     ),
 * )
 */
class GetTreeViewController extends Controller
{
}
