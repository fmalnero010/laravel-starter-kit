<?php

namespace App\Models;

use App\Builders\UserBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Users\Enums\Statuses;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string $status
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $email_verified_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasRoles;
    use HasPermissions;
    use Notifiable;
    use SoftDeletes;

    protected static string $builder = UserBuilder::class;

    protected $guarded = [
        'id',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $hidden = [
        'email_verified_at',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return Attribute<Statuses, string>
     */
    public function status(): Attribute
    {
        return Attribute::make(
            get: fn (string $status, array $attributes): Statuses => Statuses::from($status),
            set: fn (Statuses $status): string => $status->value,
        );
    }
}
