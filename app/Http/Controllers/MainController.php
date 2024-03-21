<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Racks API documentation"
 * ),
 *
 * @OA\PathItem(path="/api/"),
 *
 * @OA\Components(
 *
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer"
 *     )
 * ),
 *
 * @OA\Schema(
 *     schema="PaginatorPreviousPage",
 *     title="Pagination previous page",
 *
 *     @OA\Property(
 *         property="url",
 *         type={"string", "null"},
 *         example=null,
 *     ),
 *     @OA\Property(
 *          property="label",
 *          type="string",
 *          example="&laquo; Previous",
 *     ),
 *     @OA\Property(
 *          property="active",
 *          type="boolean",
 *          example=false,
 *     )
 * ),
 *
 * @OA\Schema(
 *     schema="PaginatorNextPage",
 *     title="Pagination next page",
 *
 *     @OA\Property(
 *         property="url",
 *         type={"string", "null"},
 *         example="http://sitename.domain/api/auth/item/all/2?page=2",
 *     ),
 *     @OA\Property(
 *          property="label",
 *          type="string",
 *          example="Next &raquo;",
 *     ),
 *     @OA\Property(
 *          property="active",
 *          type="boolean",
 *          example=false,
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="PaginatorNumberedPage",
 *     title="Pagination numbered page",
 *
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         example="http://sitename.domain/api/auth/item/all/2?page=1",
 *     ),
 *     @OA\Property(
 *          property="label",
 *          type="string",
 *          example="1",
 *     ),
 *     @OA\Property(
 *          property="active",
 *          type="boolean",
 *          example=false,
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="PermissionExceptionResponse",
 *     title="Action not allowed for this department",
 *
 *         @OA\Property(
 *             property="message",
 *             type="string",
 *             example="Action not allowed for this department"
 *         )
 *     )
 * )
 */
class MainController extends Controller
{
    //
}
