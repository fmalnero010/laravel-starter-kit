<?php

namespace App\Annotations\Schemas\Pagination;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="pagination-meta",
 *     title="Pagination Metadata",
 *     description="Pagination details",
 *     type="object",
 *
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="from", type="integer", example=1),
 *     @OA\Property(property="to", type="integer", example=2)
 * )
 */
class PaginationMetaSchema {}
