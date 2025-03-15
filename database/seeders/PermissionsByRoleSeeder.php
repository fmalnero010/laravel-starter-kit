<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Permissions;
use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionsByRoleSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Assigning permissions to roles...');

        Role::query()
            ->whereIn('name', $this->getRolesWithPermissions())
            ->each(
                fn (Role $role) => $role->syncPermissions(
                    $this->getPermissionsForRole($role->name)
                )
            );

        $this->command->info('Permissions assigned to roles successfully.');
    }

    /**
     * @return array<string>
     */
    private function getRolesWithPermissions(): array
    {
        return array_keys(
            $this->getPermissionsByRole()
        );
    }

    /**
     * @return array<string>
     */
    private function getPermissionsForRole(string $roleName): array
    {
        return collect($this->getPermissionsByRole()[$roleName] ?? [])
            ->map(fn (Permissions $p): string => $p->value)
            ->toArray();
    }

    /**
     * @return array<string, array<int, Permissions>>
     */
    private function getPermissionsByRole(): array
    {
        return [
            Roles::SuperAdmin->value => Permissions::cases(),
            Roles::Admin->value      => [
                Permissions::UsersList,
            ],
            Roles::User->value       => [],
        ];
    }
}
