<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'write_posts']);
        Permission::create(['name' => 'edit_catalog']);
        Permission::create(['name' => 'control_user']);
        Permission::create(['name' => 'edit_settings']);

        $admin_role = Role::create(['name' => 'admin']);
        $manager_role = Role::create(['name' => 'manager']);
        $writer_role = Role::create(['name' => 'writer']);
        $super_admin_role = Role::create(['name' => 'super_admin']);

        $admin_role->givePermissionTo([
            'edit_catalog',
            'control_user',
            'write_posts',
            'edit_settings',
        ]);

        $manager_role->givePermissionTo([
            'edit_catalog',
            'write_posts',
        ]);

        $writer_role->givePermissionTo([
            'write_posts',
        ]);

        $super_admin = User::create([
            'login' => 'super_admin',
            'name' => 'Main',
            'surname' => 'Director',
            'email' => 'trrt1004@gmail.com',
            'password' => Hash::make('Zzxcasd1!'),
        ]);
        $super_admin->assignRole($super_admin_role);

        $admin = User::create([
            'login' => 'admin1',
            'name' => 'Just',
            'surname' => 'Admin',
            'email' => 'anymail@anydomain.any',
            'password' => Hash::make('demonstration2024'),
        ]);
        $admin->assignRole($admin_role);

        $manager = User::create([
            'login' => 'manager1',
            'name' => 'Just',
            'surname' => 'Manager',
            'email' => 'trrt1004@gmaissl.com',
            'password' => Hash::make('Zzxcasd1!'),
        ]);
        $manager->assignRole($manager_role);
    }
}
