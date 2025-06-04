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
            'abreviatura' => 'DIR',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Subdirección Académica',
            'abreviatura' => 'SAC',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Subdirección de Servicios Administrativos',
            'abreviatura' => 'SAD',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Subdirección de Planeación y Vinculación',
            'abreviatura' => 'SPV',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias Básicas',
            'abreviatura' => 'CB',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias Económico Administrativo',
            'abreviatura' => 'CEA',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ciencias de la Tierra',
            'abreviatura' => 'CT',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Desarrollo Académico',
            'abreviatura' => 'DA',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Eléctrica',
            'abreviatura' => 'IE',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Electrónica',
            'abreviatura' => 'IEE',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ingeniería Idustrial',
            'abreviatura' => 'II',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Ingeniería Química',
            'abreviatura' => 'IQ',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Metal Mecánica',
            'abreviatura' => 'IM',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Sistemas y Computación',
            'abreviatura' => 'SC',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'División de Estudios de Posgrado e Investigación',
            'abreviatura' => 'DEPI',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'División de Estudios Profesionales',
            'abreviatura' => 'DEP',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Comunicación y Difusión',
            'abreviatura' => 'CD',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Humanos',
            'abreviatura' => 'RH',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Mantenimiento y Equipo',
            'abreviatura' => 'ME',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Financieros',
            'abreviatura' => 'RF',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Recursos Materiales y Servicios',
            'abreviatura' => 'RMS',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Actividades Extraescolares',
            'abreviatura' => 'DAE',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Gestión Tecnológica y Vinculación',
            'abreviatura' => 'GTV',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Planeación Programación y Presupuestación',
            'abreviatura' => 'PPP',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Servicios Escolares',
            'abreviatura' => 'SE',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Departamento de Centro de Cómputo',
            'abreviatura' => 'CC',
            'folio' => 1
        ]);
        Departamento::create([
            'nombre' => 'Sindicato',
            'abreviatura' => 'SIND',
            'folio' => 1
        ]);
    }
}
