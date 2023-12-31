<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create-order',
            'edit-order',
            'delete-order',
            'list-order',
            'view-order',
            'create-vehicle',
            'edit-vehicle',
            'delete-vehicle',
            'list-vehicle',
            'view-vehicle',
            'create-user',
            'edit-user',
            'delete-user',
            'list-user',
            'view-user',
            'approve-order',
            'start-order',
            'finish-order',
            'dashboard',
            'export-report',
        ];
        $roles = [
            [
                'role' => 'admin',
                'permissions' => [
                    'create-order',
                    'edit-order',
                    'delete-order',
                    'list-order',
                    'view-order',
                    'create-vehicle',
                    'edit-vehicle',
                    'delete-vehicle',
                    'list-vehicle',
                    'view-vehicle',
                    'create-user',
                    'edit-user',
                    'delete-user',
                    'list-user',
                    'view-user',
                    'export-report',
                    'dashboard',
                ],
            ],
            [
                'role' => 'leader',
                'permissions' => [
                    'list-order',
                    'view-order',
                    'view-vehicle',
                    'list-vehicle',
                    'view-user',
                ],
            ],
            [
                'role' => 'driver',
                'permissions' => [
                    'view-order',
                    'view-vehicle',
                    'view-user',
                    'start-order',
                    'finish-order',
                ]
            ]
        ];

        Permission::truncate();
        Role::truncate();
        DB::table('role_has_permissions')
            ->truncate();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($roles as $role) {
            $roleData = Role::create(['name' => $role['role']]);

            foreach ($role['permissions'] as $rolePermission) {
                $perm = Permission::findByName($rolePermission);
                $roleData->givePermissionTo($perm);
            }
        }

        Schema::enableForeignKeyConstraints();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
