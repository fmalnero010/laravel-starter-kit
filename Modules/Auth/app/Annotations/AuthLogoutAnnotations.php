<?php

namespace Modules\Auth\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *      path="/api/auth/logout",
 *      operationId="auth-logout",
 *      tags={"Auth"},
 *      summary="Logout",
 *      description="Logs a user out",
 *
 *      @OA\Response(
 *          response=204,
 *          description="No Content"
 *      ),
 *
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *
 *          @OA\JsonContent(ref="#/components/schemas/unauthenticated")
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Internal Server Error",
 *
 *          @OA\JsonContent(ref="#/components/schemas/server-error")
 *      )
 * )
 */
class AuthLogoutAnnotations {}
