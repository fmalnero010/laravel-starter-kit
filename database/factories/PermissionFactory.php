<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Permissions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Permission;

class PermissionFactory extends Factory
{
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'guard_name' => 'api',
        ];
    }

    public function withName(Permissions $permission): static
    {
        return $this->state(fn (array $attributes): array => [
            'name' => $permission->value
        ]);
    }
}
