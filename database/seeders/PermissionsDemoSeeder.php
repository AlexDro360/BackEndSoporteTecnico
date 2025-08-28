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
        Permission::create(['guard_name' => 'api', 'name' => 'asign_tecnico']);
        Permission::create(['guard_name' => 'api', 'name' => 'decline_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'response_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_bitacora_solicitud']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_bitacora']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_bitacora']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_extra']);
        Permission::create(['guard_name' => 'api', 'name' => 'add_Jefe']);
        Permission::create(['guard_name' => 'api', 'name' => 'reload_folio_respuesta']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_folio_respuesta']);
        Permission::create(['guard_name' => 'api', 'name' => 'reload_folio_solicitud']);
        Permission::create(['guard_name' => 'api', 'name' => 'edit_folio_solicitud']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_my_solicitudes']);
        Permission::create(['guard_name' => 'api', 'name' => 'register_my_solicitudes']);
        Permission::create(['guard_name' => 'api', 'name' => 'view_response_my_solicitudes']);

        Permission::create(['guard_name' => 'api', 'name' => 'view_dashboard']);

        $role3 = Role::create(['guard_name' => 'api', 'name' => 'Super-Admin']);

        $roleTecnico = Role::create(['guard_name' => 'api', 'name' => 'Técnico']);
        $rolJefeCC = Role::create(['guard_name' => 'api', 'name' => 'Jefe Depto.']);
        $rolJefeCC->givePermissionTo([
           'view_my_solicitudes',
            'register_my_solicitudes',
            'view_response_my_solicitudes'
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
            'disponibilidad' => true,
        ]);
        $user->assignRole($role3);


        // $tecnicos = \App\Models\User::factory()->count(3)->create([
        //     'password' => bcrypt('12345678'),
        //     'role_id' => 2,
        //     'departamento_id' => 10,
        //     'status' => true,
        //     'disponibilidad' => true,
        // ]);

        // $userJD = \App\Models\User::factory()->count(50)->create([
        //     'password' => bcrypt('12345678'),
        //     'role_id' => 3,
        //     'status' => true,
        //     'disponibilidad' => true,
        //     'departamento_id' => 1,
        // ])->each(function ($user) {
        //     $user->update([
        //         'departamento_id' => rand(1, 27),
        //     ]);
        // });


        // foreach ($tecnicos as $tecnico) {
        //     $tecnico->assignRole($roleTecnico);
        // }
    }
}
