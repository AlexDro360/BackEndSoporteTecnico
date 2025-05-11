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
        Estado::create(['nombre'=>'Recibida']);
        Estado::create(['nombre'=>'Rechazada']);
        Estado::create(['nombre'=>'Asignada']);
        Estado::create(['nombre'=>'En proceso']);
        Estado::create(['nombre'=>'Finalizada']);
    }
}
