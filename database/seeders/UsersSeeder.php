<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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



User::create([
    'name' => 'Carlos',
    'surnameP' => 'Ramírez',
    'surnameM' => 'López',
    'email' => 'dir@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000001',
    'role_id' => 1,
    'departamento_id' => 1,
    'num_empleado' => 'EMP001',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Ana',
    'surnameP' => 'Gómez',
    'surnameM' => 'Fernández',
    'email' => 'sac@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000002',
    'role_id' => 1,
    'departamento_id' => 2,
    'num_empleado' => 'EMP002',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Luis',
    'surnameP' => 'Hernández',
    'surnameM' => 'Castillo',
    'email' => 'sad@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000003',
    'role_id' => 1,
    'departamento_id' => 3,
    'num_empleado' => 'EMP003',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Mónica',
    'surnameP' => 'Sánchez',
    'surnameM' => 'Torres',
    'email' => 'spv@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000004',
    'role_id' => 1,
    'departamento_id' => 4,
    'num_empleado' => 'EMP004',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Jorge',
    'surnameP' => 'Pérez',
    'surnameM' => 'Jiménez',
    'email' => 'cb@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000005',
    'role_id' => 1,
    'departamento_id' => 5,
    'num_empleado' => 'EMP005',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Lucía',
    'surnameP' => 'Martínez',
    'surnameM' => 'Aguilar',
    'email' => 'cea@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000006',
    'role_id' => 1,
    'departamento_id' => 6,
    'num_empleado' => 'EMP006',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Fernando',
    'surnameP' => 'Reyes',
    'surnameM' => 'Morales',
    'email' => 'ct@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000007',
    'role_id' => 1,
    'departamento_id' => 7,
    'num_empleado' => 'EMP007',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Patricia',
    'surnameP' => 'Ortiz',
    'surnameM' => 'Delgado',
    'email' => 'da@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000008',
    'role_id' => 1,
    'departamento_id' => 8,
    'num_empleado' => 'EMP008',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Ricardo',
    'surnameP' => 'Cruz',
    'surnameM' => 'Vargas',
    'email' => 'ie@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000009',
    'role_id' => 1,
    'departamento_id' => 9,
    'num_empleado' => 'EMP009',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Valeria',
    'surnameP' => 'Domínguez',
    'surnameM' => 'Navarro',
    'email' => 'iee@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000010',
    'role_id' => 1,
    'departamento_id' => 10,
    'num_empleado' => 'EMP010',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Daniel',
    'surnameP' => 'Mendoza',
    'surnameM' => 'Carrillo',
    'email' => 'ii@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000011',
    'role_id' => 1,
    'departamento_id' => 11,
    'num_empleado' => 'EMP011',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Elena',
    'surnameP' => 'Silva',
    'surnameM' => 'Peña',
    'email' => 'iq@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000012',
    'role_id' => 1,
    'departamento_id' => 12,
    'num_empleado' => 'EMP012',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Alberto',
    'surnameP' => 'Castañeda',
    'surnameM' => 'Rojas',
    'email' => 'im@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000013',
    'role_id' => 1,
    'departamento_id' => 13,
    'num_empleado' => 'EMP013',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Isabel',
    'surnameP' => 'Vega',
    'surnameM' => 'Luna',
    'email' => 'sc@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000014',
    'role_id' => 1,
    'departamento_id' => 14,
    'num_empleado' => 'EMP014',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Diego',
    'surnameP' => 'Acosta',
    'surnameM' => 'Salazar',
    'email' => 'depi@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000015',
    'role_id' => 1,
    'departamento_id' => 15,
    'num_empleado' => 'EMP015',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Sofía',
    'surnameP' => 'Núñez',
    'surnameM' => 'Campos',
    'email' => 'dep@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000016',
    'role_id' => 1,
    'departamento_id' => 16,
    'num_empleado' => 'EMP016',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Emilio',
    'surnameP' => 'Guerrero',
    'surnameM' => 'Estrada',
    'email' => 'cd@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000017',
    'role_id' => 1,
    'departamento_id' => 17,
    'num_empleado' => 'EMP017',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Alejandra',
    'surnameP' => 'Medina',
    'surnameM' => 'Fuentes',
    'email' => 'rh@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000018',
    'role_id' => 1,
    'departamento_id' => 18,
    'num_empleado' => 'EMP018',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Andrés',
    'surnameP' => 'Ibarra',
    'surnameM' => 'Lara',
    'email' => 'me@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000019',
    'role_id' => 1,
    'departamento_id' => 19,
    'num_empleado' => 'EMP019',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'María',
    'surnameP' => 'Galván',
    'surnameM' => 'Maldonado',
    'email' => 'rf@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000020',
    'role_id' => 1,
    'departamento_id' => 20,
    'num_empleado' => 'EMP020',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Roberto',
    'surnameP' => 'Padilla',
    'surnameM' => 'Cervantes',
    'email' => 'rms@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000021',
    'role_id' => 1,
    'departamento_id' => 21,
    'num_empleado' => 'EMP021',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Gabriela',
    'surnameP' => 'Benítez',
    'surnameM' => 'Muñoz',
    'email' => 'dae@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000022',
    'role_id' => 1,
    'departamento_id' => 22,
    'num_empleado' => 'EMP022',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Héctor',
    'surnameP' => 'Camacho',
    'surnameM' => 'Serrano',
    'email' => 'gtv@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000023',
    'role_id' => 1,
    'departamento_id' => 23,
    'num_empleado' => 'EMP023',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Beatriz',
    'surnameP' => 'Arellano',
    'surnameM' => 'Solís',
    'email' => 'ppp@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000024',
    'role_id' => 1,
    'departamento_id' => 24,
    'num_empleado' => 'EMP024',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'José',
    'surnameP' => 'Barajas',
    'surnameM' => 'Valdez',
    'email' => 'se@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000025',
    'role_id' => 1,
    'departamento_id' => 25,
    'num_empleado' => 'EMP025',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Renata',
    'surnameP' => 'Del Río',
    'surnameM' => 'Lozano',
    'email' => 'cc@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000026',
    'role_id' => 1,
    'departamento_id' => 26,
    'num_empleado' => 'EMP026',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

User::create([
    'name' => 'Marco',
    'surnameP' => 'Escobar',
    'surnameM' => 'Miranda',
    'email' => 'sind@mail',
    'password' => bcrypt('Temporal2025'),
    'phone' => '5550000027',
    'role_id' => 1,
    'departamento_id' => 27,
    'num_empleado' => 'EMP027',
    'avatar' => '',
    'status' => 1,
    'disponibilidad' => 1,
]);

    }}