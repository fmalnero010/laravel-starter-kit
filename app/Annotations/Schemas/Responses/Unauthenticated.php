<?php

namespace App\Annotations\Schemas\Responses;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="unauthenticated",
 *     title="Unauthenticated",
 *     description="You are not logged in.",
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
 *         example="You are not logged in."
 *     )
 * )
 */
class Unauthenticated {}
