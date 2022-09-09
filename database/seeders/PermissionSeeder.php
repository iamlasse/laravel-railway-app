<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        // Company Users (Users)
        Role::create(['name' => 'company-user'])
            ->givePermissionTo(
                [
                Permission::create(['name' => 'view-company']),
                // Permission::create(['name' => 'view-offer']),
                // Permis/sion::create(['name' => 'manage-order']),
                // Permission::create(['name' => 'edit-subscriptions']),
                // Permission::create(['name' => 'manage-subscriptions'])
                ]
            );

        // Company Admins (Reps)
        Role::create(['name' => 'company-admin'])
            ->givePermissionTo(Permission::all())
            ->givePermissionTo(
                [
                Permission::create(['name' => 'view-companies']),
                Permission::create(['name' => 'edit-companies']),
                Permission::create(['name' => 'create-companies']),
                Permission::create(['name' => 'manage-company']),
                ]
            );
        
        // Superadmin
        Permission::create(['name' => 'view-system']);
        Role::create(['name' => 'super-admin'])->givePermissionTo(Permission::all());
    }
}
