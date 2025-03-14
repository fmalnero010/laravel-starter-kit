<?php

namespace Modules\Users\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/users",
 *      operationId="users-index",
 *      tags={"Users"},
 *      summary="Paginated list of users",
 *      description="Returns a paginated list of users; accepts filters and paginate",
 *      @OA\Response(
 *          response=200,
 *          description="successful operation"
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad request"
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden",
 *          @OA\JsonContent(ref="#/components/schemas/unauthorized")
 *      ),
 *      @OA\Response(
 *         response=422,
 *         description="Validation Error",
 *         @OA\JsonContent(ref="#/components/schemas/validation-error")
 *      )
 * )
 */
class UsersIndexControllerAnnotations
{
}
