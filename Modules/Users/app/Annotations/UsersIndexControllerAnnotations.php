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
 *         response=200,
 *         description="successful operation"
 *      ),
 *      @OA\Response(response=400, description="Bad request"),
 *          security={
 *              {"api_key_security_example": {}}
 *          }
 *     )
 *
 * Returns list of projects
 */
class UsersIndexControllerAnnotations
{
}
