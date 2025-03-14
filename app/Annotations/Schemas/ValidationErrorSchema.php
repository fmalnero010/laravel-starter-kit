<?php

namespace App\Annotations\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="validation-error",
 *     title="Validation Error",
 *     description="One or more fields have an error.",
 *     type="object",
 *     required={"message"},
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
 *         property="data",
 *         type="string",
 *         example="The field :field :problem"
 *     )
 * )
 */
class ValidationErrorSchema
{
}
