<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding roles...');

        Role::query()->upsert(
            values: $this->getRolesArray(),
            uniqueBy: ['name', 'guard_name'],
            update: []
        );

        $this->command->info('Roles seeded successfully.');
    }

    /**
     * @return array<int, array{name: string}>
     */
    private function getRolesArray(): array
    {
        return collect(Roles::cases())
            ->map(
                fn (Roles $role): array => [
                    'name'       => $role->value,
                    'guard_name' => 'api',
                ]
            )
            ->toArray();
    }
}
