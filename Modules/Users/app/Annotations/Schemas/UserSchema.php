<?php

namespace Modules\Users\Annotations\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="user",
 *     title="User",
 *     description="User model representation",
 *     type="object",
 *     required={"id", "status", "firstName", "lastName", "email"},
 *
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="status", type="string", enum={"A", "P", "I"}, example="A"),
 *     @OA\Property(property="firstName", type="string", example="Facundo"),
 *     @OA\Property(property="lastName", type="string", example="Malnero"),
 *     @OA\Property(property="email", type="string", format="email", example="facundomalnero010@gmail.com")
 * )
 */
class UserSchema {}
