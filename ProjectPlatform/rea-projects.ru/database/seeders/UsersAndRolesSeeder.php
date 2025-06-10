<?php

namespace Database\Seeders;

use App\Models\RegistrationToken;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UsersAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_token = RegistrationToken::create([
            'token' => 'SuperAdminToken',
        ]);

        $user_token = RegistrationToken::create([
            'token' => 'UserToken',
        ]);

        $super_admin_role = Role::create(['name' => 'super_admin']);
        $admin_role = Role::create(['name' => 'admin']);
        
        $god_permission = Permission::create(['name' => 'god']);
        $manage_roles_permission = Permission::create(['name' => 'manage_roles']);
        $moderate_permission = Permission::create(['name' => 'moderate']);
        $projects_control_permission = Permission::create(['name' => 'control_projects']);

        $super_admin_role->givePermissionTo($god_permission);
        $super_admin_role->givePermissionTo($manage_roles_permission);
        $super_admin_role->givePermissionTo($moderate_permission);
        $super_admin_role->givePermissionTo($projects_control_permission);
        
        $admin_role->givePermissionTo($manage_roles_permission);
        $admin_role->givePermissionTo($moderate_permission);
        $admin_role->givePermissionTo($projects_control_permission);

        $super_admin = User::create([
            'login' => 'Kot_baun',
            'password' => 'Zzxcasd1!',
            'registration_token_id' => $admin_token->id,
        ]);

        User::create([
            'login' => 'user',
            'password' => '123456',
            'registration_token_id' => $user_token->id,
        ]);

        $super_admin->assignRole('super_admin');
        
    }
}
