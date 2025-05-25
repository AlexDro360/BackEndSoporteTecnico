<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento;


class DepartamentosSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
            'nombre' => 'Dirección',
            'abreviatura' => 'DIR'
        ]);
        Departamento::create([
            'nombre' => 'Subdirección Académica',
            'abreviatura' => 'SAC'
        ]);
        Departamento::create([
            'nombre' => 'Subdirección de Servicios Administrativos',
            'abreviatura' => 'SAD'
        ]);
        Departamento::create([
            'nombre' => 'Subdirección de Planeación y Vinculación',
            'abreviatura' => 'SPV'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias Básicas',
            'abreviatura' => 'CB'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias Económico Administrativo',
            'abreviatura' => 'CEA'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias de la Tierra',
            'abreviatura' => 'CT'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Desarrollo Académico',
            'abreviatura' => 'DA'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Eléctrica',
            'abreviatura' => 'IE'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Electrónica',
            'abreviatura' => 'IEE'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ingeniería Idustrial',
            'abreviatura' => 'II'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ingeniería Química',
            'abreviatura' => 'IQ'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Metal Mecánica',
            'abreviatura' => 'IM'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Sistemas y Computación',
            'abreviatura' => 'SC'
        ]);
        Departamento::create([
            'nombre' => 'División de Estudios de Posgrado e Investigación',
            'abreviatura' => 'DEPI'
        ]);
        Departamento::create([
            'nombre' => 'División de Estudios Profesionales',
            'abreviatura' => 'DEP'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Comunicación y Difusión',
            'abreviatura' => 'CD'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Humanos',
            'abreviatura' => 'RH'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Mantenimiento y Equipo',
            'abreviatura' => 'ME'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Financieros',
            'abreviatura' => 'RF'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Materiales y Servicios',
            'abreviatura' => 'RMS'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Actividades Extraescolares',
            'abreviatura' => 'DAE'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Gestión Tecnológica y Vinculación',
            'abreviatura' => 'GTV'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Planeación Programación y Presupuestación',
            'abreviatura' => 'PPP'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Servicios Escolares',
            'abreviatura' => 'SE'
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Centro de Cómputo',
            'abreviatura' => 'CC'
        ]);
        Departamento::create([
            'nombre' => 'Sindicato',
            'abreviatura' => 'SIND'
        ]);
    }
}
