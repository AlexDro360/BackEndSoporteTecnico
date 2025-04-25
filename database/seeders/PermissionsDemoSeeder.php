<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['guard_name' => 'api', 'name' => 'view_role']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_role']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_role']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_role']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_user']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_user']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_solicitud']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_response']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_response']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_response']);
        Permission::create(['guard_name' => 'api', 'name' => 'delete_response']);

        // create roles and assign existing permissions
        // $role1 = Role::create(['guard_name' => 'api','name' => 'writer']);
        // $role1->givePermissionTo('edit articles');
        // $role1->givePermissionTo('delete articles');

        // $role2 = Role::create(['guard_name' => 'api','name' => 'admin']);
        // $role2->givePermissionTo('publish articles');
        // $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['guard_name' => 'api', 'name' => 'Super-Admin']);

        $rolePruebas = Role::create(['guard_name' => 'api', 'name' => 'Pruebas']);
        $rolePruebas->givePermissionTo([
            'view_user',
            'register_user',
            'edit_user',
            'delete_user',
        ]);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt("12345678"),
        // ]);
        // $user->assignRole($role1);

        // $user = \App\Models\User::factory()->create([
        //     'name' => 'Example Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt("12345678"),
        // ]);
        // $user->assignRole($role2);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super_admin_crm@gmail.com',
            'password' => bcrypt("12345678"),
            'role_id' => '1',
            'departamento_id' => 1,
            'status' => true,
        ]);
        $user->assignRole($role3);


        $user = \App\Models\User::factory()->create([
            'name' => 'Benito Camelo',
            'surname' => 'Hernandez',
            'email' => 'benito@gmail.com',
            'password' => bcrypt("12345678"),
            'role_id' => '1',
            'departamento_id' => 10,
            'status' => true,
        ]);
        $user->assignRole($rolePruebas);
    }
}
