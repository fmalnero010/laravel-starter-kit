<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Permissions;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding permissions...');

        Permission::query()->upsert(
            values: $this->getPermissionsArray(),
            uniqueBy: ['name', 'guard_name'],
            update: []
        );

        $this->command->info('Permissions seeded successfully.');
    }

    /**
     * @return array<int, array{name: string}>
     */
    private function getPermissionsArray(): array
    {
        return array_map(
            fn (Permissions $permission): array => [
                'name'       => $permission->value,
                'guard_name' => 'api',
            ],
            Permissions::cases()
        );
    }
}
