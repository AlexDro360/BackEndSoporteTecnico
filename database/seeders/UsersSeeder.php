<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {

        $rolJefeCC = Role::create(['guard_name' => 'api', 'name' => 'Jefe Depto.']);
        $rolJefeCC->givePermissionTo([
           'view_my_solicitudes',
            'register_my_solicitudes',
            'view_response_my_solicitudes'
        ]);

 $user1 = \App\Models\User::factory()->create([
    'name' => 'JefeCC',
    'surnameP' => 'computo',
    'surnameM' => 'tecnm',
    'email' => 'jefecc@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 4,
    'departamento_id' => 26,
    'num_empleado' => '1000',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user1->assignRole($rolJefeCC);
 $user2 = \App\Models\User::factory()->create([
    'name' => 'tecnico1',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec1@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '101',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user2->assignRole($rolJefeCC);

 $user3 = \App\Models\User::factory()->create([
    'name' => 'tecnico2',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec2@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '102',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user3->assignRole($rolJefeCC);

 $user4 = \App\Models\User::factory()->create([
    'name' => 'tecnico3',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec3@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '103',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user4->assignRole($rolJefeCC);

$user5 = \App\Models\User::factory()->create([
    'name' => 'tecnico4',
    'surnameP' => 'ito',
    'surnameM' => 'tecnm',
    'email' => 'tec4@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 2,
    'departamento_id' => 26,
    'num_empleado' => '104',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user5->assignRole($rolJefeCC);

 $user6 = \App\Models\User::factory()->create([
    'name' => 'Carlos',
    'surnameP' => 'Ramírez',
    'surnameM' => 'López',
    'email' => 'dir@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000001',
    'role_id' => 3,
    'departamento_id' => 1,
    'num_empleado' => 'EMP001',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user6->assignRole($rolJefeCC);

$user7 = \App\Models\User::factory()->create([
    'name' => 'Ana',
    'surnameP' => 'Gómez',
    'surnameM' => 'Fernández',
    'email' => 'sac@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000002',
    'role_id' => 3,
    'departamento_id' => 2,
    'num_empleado' => 'EMP002',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user7->assignRole($rolJefeCC);

 $user8 = \App\Models\User::factory()->create([
    'name' => 'Luis',
    'surnameP' => 'Hernández',
    'surnameM' => 'Castillo',
    'email' => 'sad@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000003',
    'role_id' => 3,
    'departamento_id' => 3,
    'num_empleado' => 'EMP003',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user8->assignRole($rolJefeCC);
 $user9 = \App\Models\User::factory()->create([
    'name' => 'Mónica',
    'surnameP' => 'Sánchez',
    'surnameM' => 'Torres',
    'email' => 'spv@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000004',
    'role_id' => 3,
    'departamento_id' => 4,
    'num_empleado' => 'EMP004',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
    $user9->assignRole($rolJefeCC);
 $user10 = \App\Models\User::factory()->create([
    'name' => 'Jorge',
    'surnameP' => 'Pérez',
    'surnameM' => 'Jiménez',
    'email' => 'cb@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000005',
    'role_id' => 3,
    'departamento_id' => 5,
    'num_empleado' => 'EMP005',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user10->assignRole($rolJefeCC);

 $user11 = \App\Models\User::factory()->create([
    'name' => 'Lucía',
    'surnameP' => 'Martínez',
    'surnameM' => 'Aguilar',
    'email' => 'cea@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000006',
    'role_id' => 3,
    'departamento_id' => 6,
    'num_empleado' => 'EMP006',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user11->assignRole($rolJefeCC);

 $user12 = \App\Models\User::factory()->create([
    'name' => 'Fernando',
    'surnameP' => 'Reyes',
    'surnameM' => 'Morales',
    'email' => 'ct@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000007',
    'role_id' => 3,
    'departamento_id' => 7,
    'num_empleado' => 'EMP007',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user12->assignRole($rolJefeCC);

 $user13 = \App\Models\User::factory()->create([
    'name' => 'Patricia',
    'surnameP' => 'Ortiz',
    'surnameM' => 'Delgado',
    'email' => 'da@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000008',
    'role_id' => 3,
    'departamento_id' => 8,
    'num_empleado' => 'EMP008',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user13->assignRole($rolJefeCC);

$user14 = \App\Models\User::factory()->create([
    'name' => 'Ricardo',
    'surnameP' => 'Cruz',
    'surnameM' => 'Vargas',
    'email' => 'ie@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000009',
    'role_id' => 3,
    'departamento_id' => 9,
    'num_empleado' => 'EMP009',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user14->assignRole($rolJefeCC);

 $user15 = \App\Models\User::factory()->create([
    'name' => 'Valeria',
    'surnameP' => 'Domínguez',
    'surnameM' => 'Navarro',
    'email' => 'iee@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000010',
    'role_id' => 3,
    'departamento_id' => 10,
    'num_empleado' => 'EMP010',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user15->assignRole($rolJefeCC);

$user16 = \App\Models\User::factory()->create([
    'name' => 'Daniel',
    'surnameP' => 'Mendoza',
    'surnameM' => 'Carrillo',
    'email' => 'ii@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000011',
    'role_id' => 3,
    'departamento_id' => 11,
    'num_empleado' => 'EMP011',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user16->assignRole($rolJefeCC);


 $user17 = \App\Models\User::factory()->create([
    'name' => 'Elena',
    'surnameP' => 'Silva',
    'surnameM' => 'Peña',
    'email' => 'iq@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000012',
    'role_id' => 3,
    'departamento_id' => 12,
    'num_empleado' => 'EMP012',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user17->assignRole($rolJefeCC);

 $user18 = \App\Models\User::factory()->create([
    'name' => 'Alberto',
    'surnameP' => 'Castañeda',
    'surnameM' => 'Rojas',
    'email' => 'im@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000013',
    'role_id' => 3,
    'departamento_id' => 13,
    'num_empleado' => 'EMP013',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user18->assignRole($rolJefeCC);

$user19 = \App\Models\User::factory()->create([
    'name' => 'Isabel',
    'surnameP' => 'Vega',
    'surnameM' => 'Luna',
    'email' => 'sc@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000014',
    'role_id' => 3,
    'departamento_id' => 14,
    'num_empleado' => 'EMP014',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user19->assignRole($rolJefeCC);

 $user20 = \App\Models\User::factory()->create([
    'name' => 'Diego',
    'surnameP' => 'Acosta',
    'surnameM' => 'Salazar',
    'email' => 'depi@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000015',
    'role_id' => 3,
    'departamento_id' => 15,
    'num_empleado' => 'EMP015',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user20->assignRole($rolJefeCC);

$user21 = \App\Models\User::factory()->create([
    'name' => 'Sofía',
    'surnameP' => 'Núñez',
    'surnameM' => 'Campos',
    'email' => 'dep@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000016',
    'role_id' => 3,
    'departamento_id' => 16,
    'num_empleado' => 'EMP016',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user21->assignRole($rolJefeCC);

 $user22 = \App\Models\User::factory()->create([
    'name' => 'Emilio',
    'surnameP' => 'Guerrero',
    'surnameM' => 'Estrada',
    'email' => 'cd@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000017',
    'role_id' => 3,
    'departamento_id' => 17,
    'num_empleado' => 'EMP017',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user22->assignRole($rolJefeCC);

$user23 = \App\Models\User::factory()->create([
    'name' => 'Alejandra',
    'surnameP' => 'Medina',
    'surnameM' => 'Fuentes',
    'email' => 'rh@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000018',
    'role_id' => 3,
    'departamento_id' => 18,
    'num_empleado' => 'EMP018',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user23->assignRole($rolJefeCC);

 $user24 = \App\Models\User::factory()->create([
    'name' => 'Andrés',
    'surnameP' => 'Ibarra',
    'surnameM' => 'Lara',
    'email' => 'me@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000019',
    'role_id' => 3,
    'departamento_id' => 19,
    'num_empleado' => 'EMP019',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user24->assignRole($rolJefeCC);

 $user25 = \App\Models\User::factory()->create([
    'name' => 'María',
    'surnameP' => 'Galván',
    'surnameM' => 'Maldonado',
    'email' => 'rf@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 3,
    'departamento_id' => 20,
    'num_empleado' => 'EMP020',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user25->assignRole($rolJefeCC);

$user26 = \App\Models\User::factory()->create([
    'name' => 'Roberto',
    'surnameP' => 'Padilla',
    'surnameM' => 'Cervantes',
    'email' => 'rms@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000021',
    'role_id' => 3,
    'departamento_id' => 21,
    'num_empleado' => 'EMP021',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user26->assignRole($rolJefeCC);

 $user27 = \App\Models\User::factory()->create([
    'name' => 'Gabriela',
    'surnameP' => 'Benítez',
    'surnameM' => 'Muñoz',
    'email' => 'dae@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000022',
    'role_id' => 3,
    'departamento_id' => 22,
    'num_empleado' => 'EMP022',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user27->assignRole($rolJefeCC);

$user28 = \App\Models\User::factory()->create([
    'name' => 'Héctor',
    'surnameP' => 'Camacho',
    'surnameM' => 'Serrano',
    'email' => 'gtv@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000023',
    'role_id' => 3,
    'departamento_id' => 23,
    'num_empleado' => 'EMP023',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user28->assignRole($rolJefeCC);

 $user29 = \App\Models\User::factory()->create([
    'name' => 'Beatriz',
    'surnameP' => 'Arellano',
    'surnameM' => 'Solís',
    'email' => 'ppp@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000024',
    'role_id' => 3,
    'departamento_id' => 24,
    'num_empleado' => 'EMP024',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user29->assignRole($rolJefeCC);

 $user30 = \App\Models\User::factory()->create([
    'name' => 'José',
    'surnameP' => 'Barajas',
    'surnameM' => 'Valdez',
    'email' => 'se@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000025',
    'role_id' => 3,
    'departamento_id' => 25,
    'num_empleado' => 'EMP025',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user30->assignRole($rolJefeCC);

 $user31 = \App\Models\User::factory()->create([
    'name' => 'Renata',
    'surnameP' => 'Del Río',
    'surnameM' => 'Lozano',
    'email' => 'cc@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000026',
    'role_id' => 3,
    'departamento_id' => 26,
    'num_empleado' => 'EMP026',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user31->assignRole($rolJefeCC);

$user32 = \App\Models\User::factory()->create([
    'name' => 'Marco',
    'surnameP' => 'Escobar',
    'surnameM' => 'Miranda',
    'email' => 'sind@mail.com',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000027',
    'role_id' => 3,
    'departamento_id' => 27,
    'num_empleado' => 'EMP027',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);
$user32->assignRole($rolJefeCC);
    }}