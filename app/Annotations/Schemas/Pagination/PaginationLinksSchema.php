<?php

namespace App\Annotations\Schemas\Pagination;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="pagination-links",
 *     title="Pagination Links",
 *     description="Links for navigating paginated results",
 *     type="object",
 *     @OA\Property(property="first", type="string", nullable=true, example="http://localhost/api/users?paginate[page]=1"),
 *     @OA\Property(property="prev", type="string", nullable=true, example="http://localhost/api/users?paginate[page]=1"),
 *     @OA\Property(property="next", type="string", nullable=true, example="http://localhost/api/users?paginate[page]=2")
 * )
 */
class PaginationLinksSchema
{
}
