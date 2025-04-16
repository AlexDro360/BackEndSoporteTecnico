<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estado::create(['nombre'=>'Espera']);
        Estado::create(['nombre'=>'Asignado']);
        Estado::create(['nombre'=>'Revisión']);
        Estado::create(['nombre'=>'Espera De Parte']);
        Estado::create(['nombre'=>'Concluido']);
        Estado::create(['nombre'=>'Rechazado']);
    }
}
