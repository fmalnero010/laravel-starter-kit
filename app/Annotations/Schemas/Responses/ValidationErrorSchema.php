<?php

namespace App\Annotations\Schemas\Responses;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="validation-error",
 *     title="Validation Error",
 *     description="One or more fields have an error.",
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
 *         type="object",
 *         @OA\Property(
 *             property="field",
 *             type="array",
 *
 *             @OA\Items(
 *                 type="string",
 *                 example="The :field field is required."
 *             )
 *         )
 *     )
 * )
 */
class ValidationErrorSchema {}
