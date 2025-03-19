<?php

namespace App\Annotations\Schemas\Responses;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="server-error",
 *     title="Internal Server Error",
 *     description="Internal Server Error",
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
 *         example="There has been an internal server error."
 *     )
 * )
 */
class ServerErrorSchema {}
