<?php

namespace Database\Seeders;

use App\Models\Tipo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipo::create(['nombre' => 'Problema con Impresora']);
        Tipo::create(['nombre' => 'Problema con Red']);
        Tipo::create(['nombre' => 'Problema con Correo Electrónico']);
        Tipo::create(['nombre' => 'Problema con un Programa de Computadora']);
        Tipo::create(['nombre' => 'Problema con Mi Computadora']);
        Tipo::create(['nombre' => 'Solicitud de Instalación de Programa']);
        Tipo::create(['nombre' => 'Solicitud de Mantenimiento']);
        Tipo::create(['nombre' => 'Problema con Acceso a Sistemas']);
        Tipo::create(['nombre' => 'Otro']);
    }
}
