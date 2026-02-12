<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use phpDocumentor\Reflection\Types\Null_;

class UsersSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {


        
        $rolTecnico = Role::create(['guard_name' => 'api', 'name' => 'Tecnico']);
        $rolTecnico->givePermissionTo([

        ]);

        $rolJefeDept = Role::create(['guard_name' => 'api', 'name' => 'Jefe Depto.']);
        $rolJefeDept->givePermissionTo([
           'view_my_solicitudes',
            'register_my_solicitudes',
            'view_response_my_solicitudes'
        ]);

        $rolJefedeCC = Role::create(['guard_name' => 'api', 'name' => 'Jefe CC']);
        $rolJefedeCC->givePermissionTo([

        ]);




 $user2 = \App\Models\User::factory()->create([
    'name' => 'tecnico1',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tecnico1@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '101',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user2->assignRole($rolTecnico);

 $user3 = \App\Models\User::factory()->create([
    'name' => 'tecnico2',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec2@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '102',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user3->assignRole($rolTecnico);

 $user4 = \App\Models\User::factory()->create([
    'name' => 'tecnico3',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec3@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '103',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user4->assignRole($rolTecnico);

$user5 = \App\Models\User::factory()->create([
    'name' => 'tecnico4',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec4@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '104',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user5->assignRole($rolTecnico);

 $user6 = \App\Models\User::factory()->create([
    'name' => 'Silvia',
    'surnameP' => 'Santiago',
    'surnameM' => 'Cruz',
    'email' => 'direccion@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 1,
    'num_empleado' => 'EMP001',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user6->assignRole($rolJefeDept);

$user7 = \App\Models\User::factory()->create([
    'name' => 'Alma Dolores',
    'surnameP' => 'Pérez',
    'surnameM' => 'Santiago',
    'email' => 'subacademica@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 2,
    'num_empleado' => 'EMP002',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user7->assignRole($rolJefeDept);

 $user8 = \App\Models\User::factory()->create([
    'name' => 'Ángel Gildardo',
    'surnameP' => 'Castañeda',
    'surnameM' => 'López',
    'email' => 'subadministrativa@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 3,
    'num_empleado' => 'EMP003',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user8->assignRole($rolJefeDept);
 $user9 = \App\Models\User::factory()->create([
    'name' => 'pendiente',
    'surnameP' => 'pendiente',
    'surnameM' => 'pendiente',
    'email' => 'subplanvin@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 4,
    'num_empleado' => 'EMP004',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
    $user9->assignRole($rolJefeDept);
 $user10 = \App\Models\User::factory()->create([
    'name' => 'Luis Miguel',
    'surnameP' => 'Hernández',
    'surnameM' => 'Pérez',
    'email' => 'cienciasbasicas@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 5,
    'num_empleado' => 'EMP005',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user10->assignRole($rolJefeDept);

 $user11 = \App\Models\User::factory()->create([
    'name' => 'José Alfredo',
    'surnameP' => 'Reyes',
    'surnameM' => 'Juárez',
    'email' => 'cienciaseconomicoadmin@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 6,
    'num_empleado' => 'EMP006',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user11->assignRole($rolJefeDept);

 $user12 = \App\Models\User::factory()->create([
    'name' => 'Antonia',
    'surnameP' => 'López',
    'surnameM' => 'Sánchez',
    'email' => 'cienciastierra@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 7,
    'num_empleado' => 'EMP007',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user12->assignRole($rolJefeDept);

 $user13 = \App\Models\User::factory()->create([
    'name' => 'Virginia',
    'surnameP' => 'Ortíz',
    'surnameM' => 'Méndez',
    'email' => 'desarrolloacademico@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 8,
    'num_empleado' => 'EMP008',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user13->assignRole($rolJefeDept);

$user14 = \App\Models\User::factory()->create([
    'name' => 'Héctor Javier',
    'surnameP' => 'Jarquín',
    'surnameM' => 'Flores',
    'email' => 'electrica@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 9,
    'num_empleado' => 'EMP009',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user14->assignRole($rolJefeDept);

 $user15 = \App\Models\User::factory()->create([
    'name' => 'Héctor Javier',
    'surnameP' => 'Jarquín',
    'surnameM' => 'Flores',
    'email' => 'electronica@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 10,
    'num_empleado' => 'EMP010',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user15->assignRole($rolJefeDept);

$user16 = \App\Models\User::factory()->create([
    'name' => 'Martha Hilaria',
    'surnameP' => 'Bartolo',
    'surnameM' => 'Alemán',
    'email' => 'industrial@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 11,
    'num_empleado' => 'EMP011',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user16->assignRole($rolJefeDept);


 $user17 = \App\Models\User::factory()->create([
    'name' => 'Flor de Belem',
    'surnameP' => 'Pérez',
    'surnameM' => 'Chávez',
    'email' => 'quimica@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 12,
    'num_empleado' => 'EMP012',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user17->assignRole($rolJefeDept);

 $user18 = \App\Models\User::factory()->create([
    'name' => 'Grysel',
    'surnameP' => 'Pimentel',
    'surnameM' => 'Nogales',
    'email' => 'mecanica@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 13,
    'num_empleado' => 'EMP013',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user18->assignRole($rolJefeDept);


$user19 = \App\Models\User::factory()->create([
    'name' => 'Idarh Claudio',
    'surnameP' => 'Matadamas',
    'surnameM' => 'Ortiz',
    'email' => 'sistemascomputacion@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 14,
    'num_empleado' => 'EMP014',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user19->assignRole($rolJefeDept);

 $user20 = \App\Models\User::factory()->create([
    'name' => 'Iván Antonio',
    'surnameP' => 'García',
    'surnameM' => 'Montalvo',
    'email' => 'estudiosposgrado@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 15,
    'num_empleado' => 'EMP015',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user20->assignRole($rolJefeDept);

$user21 = \App\Models\User::factory()->create([
    'name' => 'elizabeth',
    'surnameP' => 'Salas',
    'surnameM' => 'Sánchez',
    'email' => 'estudiosprofesionales@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 16,
    'num_empleado' => 'EMP016',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user21->assignRole($rolJefeDept);

 $user22 = \App\Models\User::factory()->create([
    'name' => 'Juan José',
    'surnameP' => 'Martínez',
    'surnameM' => 'Caballero',
    'email' => 'comunicaciondifusion@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 17,
    'num_empleado' => 'EMP017',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user22->assignRole($rolJefeDept);

$user23 = \App\Models\User::factory()->create([
    'name' => 'Gildardo Oswaldo',
    'surnameP' => 'García',
    'surnameM' => 'Montalvo',
    'email' => 'recursoshumanos@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 18,
    'num_empleado' => 'EMP018',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user23->assignRole($rolJefeDept);

 $user24 = \App\Models\User::factory()->create([
    'name' => 'pendiente',
    'surnameP' => 'pendiente',
    'surnameM' => 'pendiente',
    'email' => 'mantenimientodeequipo@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 19,
    'num_empleado' => 'EMP019',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user24->assignRole($rolJefeDept);

 $user25 = \App\Models\User::factory()->create([
    'name' => 'Yesenia',
    'surnameP' => 'Gonzáles',
    'surnameM' => 'Guzmán',
    'email' => 'recursosfinancieros@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 20,
    'num_empleado' => 'EMP020',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user25->assignRole($rolJefeDept);

$user26 = \App\Models\User::factory()->create([
    'name' => 'Fernando',
    'surnameP' => 'Toral',
    'surnameM' => 'Enríquez',
    'email' => 'recursosmateriales@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 21,
    'num_empleado' => 'EMP021',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user26->assignRole($rolJefeDept);

 $user27 = \App\Models\User::factory()->create([
    'name' => 'pendiente',
    'surnameP' => 'pendiente',
    'surnameM' => 'pendiente',
    'email' => 'actividadesextraescolares@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 22,
    'num_empleado' => 'EMP022',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user27->assignRole($rolJefeDept);

$user28 = \App\Models\User::factory()->create([
    'name' => 'Maricela',
    'surnameP' => 'Morales',
    'surnameM' => 'Hernández',
    'email' => 'tecnologicavinculacion@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 23,
    'num_empleado' => 'EMP023',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user28->assignRole($rolJefeDept);

 $user29 = \App\Models\User::factory()->create([
    'name' => 'Sofia Janeth',
    'surnameP' => 'Jiménez',
    'surnameM' => 'Ramírez',
    'email' => 'presupuestoprogramacion@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 24,
    'num_empleado' => 'EMP024',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user29->assignRole($rolJefeDept);

 $user30 = \App\Models\User::factory()->create([
    'name' => 'Huitzili',
    'surnameP' => 'Díaz',
    'surnameM' => 'Jaimes',
    'email' => 'serviciosescolares@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 25,
    'num_empleado' => 'EMP025',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user30->assignRole($rolJefeDept);

$user32 = \App\Models\User::factory()->create([
    'name' => 'pendiente',
    'surnameP' => 'pendiente',
    'surnameM' => 'pendiente',
    'email' => 'sindicato@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 3,
    'departamento_id' => 27,
    'num_empleado' => 'EMP027',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user32->assignRole($rolJefeDept);

 $user1 = \App\Models\User::factory()->create([
    'name' => 'Claribel',
    'surnameP' => 'Benítez',
    'surnameM' => 'Quecha',
    'email' => 'jefecc@itoaxaca.edu.mx',
    'password' => bcrypt('Temporal2026!'),
    'phone' => 'XXXXXXXXXX',
    'role_id' => 4,
    'departamento_id' => 26,
    'num_empleado' => '1000',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user1->assignRole($rolJefedeCC);
    }}