<?php

namespace Modules\Users\Annotations;

use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *      path="/api/users",
 *      operationId="users-index",
 *      tags={"Users"},
 *      summary="Paginated list of users",
 *      description="Returns a paginated list of users",
 *
 *      @OA\Parameter(
 *          name="filter[firstName]",
 *          in="query",
 *          description="Filter by first name",
 *          required=false,
 *
 *          @OA\Schema(type="string")
 *      ),
 *
 *      @OA\Parameter(
 *          name="filter[lastName]",
 *          in="query",
 *          description="Filter by last name",
 *          required=false,
 *
 *          @OA\Schema(type="string")
 *      ),
 *
 *      @OA\Parameter(
 *          name="filter[email]",
 *          in="query",
 *          description="Filter by email",
 *          required=false,
 *
 *          @OA\Schema(type="string", format="email")
 *      ),
 *
 *      @OA\Parameter(
 *          name="filter[status]",
 *          in="query",
 *          description="User status",
 *          required=false,
 *
 *          @OA\Schema(type="string", enum={"A", "P", "I"})
 *      ),
 *
 *      @OA\Parameter(
 *          name="paginate[perPage]",
 *          in="query",
 *          description="Set the number of items per page",
 *          required=false,
 *
 *          @OA\Schema(type="integer")
 *      ),
 *
 *      @OA\Parameter(
 *          name="paginate[page]",
 *          in="query",
 *          description="Set the page number",
 *          required=false,
 *
 *          @OA\Schema(type="integer")
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
 *                      property="data",
 *                      type="array",
 *
 *                      @OA\Items(ref="#/components/schemas/user")
 *                  ),
 *
 *                  @OA\Property(property="links", ref="#/components/schemas/pagination-links"),
 *                  @OA\Property(property="meta", ref="#/components/schemas/pagination-meta")
 *              )
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden",
 *
 *          @OA\JsonContent(ref="#/components/schemas/unauthorized")
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
class UsersIndexControllerAnnotations {}
