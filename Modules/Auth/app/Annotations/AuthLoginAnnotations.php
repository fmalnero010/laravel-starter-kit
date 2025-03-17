<?php

namespace Modules\Auth\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *      path="/api/auth/login",
 *      operationId="auth-login",
 *      tags={"Auth"},
 *      summary="Login",
 *      description="Logs a user in",
 *
 *      @OA\Parameter(
 *          name="email",
 *          in="query",
 *          description="User's email",
 *          required=true,
 *
 *          @OA\Schema(type="string")
 *      ),
 *
 *      @OA\Parameter(
 *          name="password",
 *          in="query",
 *          description="User's password",
 *          required=true,
 *
 *          @OA\Schema(type="string")
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Paginated list of users",
 *
 *          @OA\JsonContent(
 *
 *              @OA\Property(property="status", type="integer", example=1),
 *              @OA\Property(property="message", type="string", example="SUCCESS"),
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  @OA\Property(
 *                      property="accessToken",
 *                      type="string",
 *                      example="4|6tF1Qc3fTAZPmPyDTZgqMSr55PHhm311zeGCs1IN6b596bb4"
 *                  ),
 *                  @OA\Property(
 *                      property="tokenType",
 *                      type="string",
 *                      example="Bearer"
 *                  ),
 *                  @OA\Property(
 *                      property="expiresAt",
 *                      type="string",
 *                      example="2025-09-08 14:00:00"
 *                  ),
 *                  @OA\Property(
 *                      property="user",
 *                      ref="#/components/schemas/user"
 *                  )
 *              )
 *          )
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
 *          response=422,
 *          description="Validation Error",
 *
 *          @OA\JsonContent(ref="#/components/schemas/validation-error")
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
class AuthLoginAnnotations {}
