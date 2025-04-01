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
        Departamento::create(['nombre'=>'Dirección']);
        Departamento::create(['nombre'=>'Subdirección Académica']);
        Departamento::create(['nombre'=>'Subdirección de Servicios Administrativos']);
        Departamento::create(['nombre'=>'Subdirección de Planeación y Vinculación']);
        Departamento::create(['nombre'=>'Departamento de Ciencias Básicas']);
        Departamento::create(['nombre'=>'Departamento de Ciencias Económico Administrativo']);
        Departamento::create(['nombre'=>'Departamento de Ciencias de la Tierra']);
        Departamento::create(['nombre'=>'Departamento de Desarrollo Académico']);
        Departamento::create(['nombre'=>'Departamento de Eléctrica']);
        Departamento::create(['nombre'=>'Departamento de Electrónica']);
        Departamento::create(['nombre'=>'Departamento de Ingeniería Idustrial']);
        Departamento::create(['nombre'=>'Departamento de Ingeniería Química']);
        Departamento::create(['nombre'=>'Departamento de Metal Mecánica']);
        Departamento::create(['nombre'=>'Departamento de Sistemas y Computación']);
        Departamento::create(['nombre'=>'División de Estudios de Posgrado e Investigación']);
        Departamento::create(['nombre'=>'División de Estudios Profesionales']);
        Departamento::create(['nombre'=>'Departamento de Comunicación y Difusión']);
        Departamento::create(['nombre'=>'Departamento de Recursos Humanos']);
        Departamento::create(['nombre'=>'Departamento de Mantenimiento y Equipo']);
        Departamento::create(['nombre'=>'Departamento de Recursos Financieros']);
        Departamento::create(['nombre'=>'Departamento de Recursos Materiales y Servicios']);
        Departamento::create(['nombre'=>'Departamento de Actividades Extraescolares']);
        Departamento::create(['nombre'=>'Departamento de Gestión Tecnológica y Vinculación']);
        Departamento::create(['nombre'=>'Departamento de Planeación Programación y Presupuestación']);
        Departamento::create(['nombre'=>'Departamento de Servicios Escolares']);
        Departamento::create(['nombre'=>'Departamento de Centro de Cómputo']);
        Departamento::create(['nombre'=>'Sindicato']);
    }
}