<?php

namespace Modules\Users\Transformers;

use App\Models\User;
use App\Transformers\BaseResource;
use Illuminate\Http\Request;

class UserResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        /** @var User $user */
        $user = $this->resource;

        return [
            'id'        => $user->id,
            'status'    => $user->status,
            'firstName' => $user->first_name,
            'lastName'  => $user->last_name,
            'email'     => $user->email,
        ];
    }
}
