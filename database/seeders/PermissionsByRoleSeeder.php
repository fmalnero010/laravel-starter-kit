<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Roles;
use App\Services\PermissionCollector;
use BackedEnum;
use Illuminate\Database\Seeder;
use Modules\Users\Enums\UserPermissions;
use Spatie\Permission\Models\Role;

class PermissionsByRoleSeeder extends Seeder
{
    public function __construct(private readonly PermissionCollector $permissionCollector)
    {
    }

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
        return array_map(
            fn (BackedEnum $p): string => $p->value,
            $this->getPermissionsByRole()[$roleName] ?? []
        );
    }

    /**
     * @return array<string, array<int, BackedEnum>>
     */
    private function getPermissionsByRole(): array
    {
        return [
            Roles::SuperAdmin->value => $this->permissionCollector->all(),
            Roles::Admin->value => UserPermissions::cases(),
            Roles::User->value => [],
        ];
    }
}
