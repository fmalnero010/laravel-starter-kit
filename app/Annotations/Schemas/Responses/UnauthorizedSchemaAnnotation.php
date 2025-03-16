<?php

namespace App\Annotations\Schemas\Responses;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="unauthorized",
 *     title="Forbidden",
 *     description="You don't have permission to access this resource.",
 *     type="object",
 *     required={"message"},
 *
 *     @OA\Property(
 *         property="status",
 *         type="integer",
 *         example=-1
 *     ),
 *     @OA\Property(
 *         property="message",
 *         type="string",
 *         example="ERROR"
 *     ),
 *     @OA\Property(
 *         property="error",
 *         type="string",
 *         example="This action is unauthorized."
 *     )
 * )
 */
class UnauthorizedSchemaAnnotation {}
