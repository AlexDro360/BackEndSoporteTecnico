<?php

namespace Database\Seeders;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class solicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        for ($i = 0; $i < 1000; $i++) {
            // Fecha aleatoria en el último año
            $randomDate = Carbon::now()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            DB::table('solicituds')->insert([
                'folio' => rand(1000, 9999),
                'idUser' => rand(2, 50),
                'descripcionUser' => 'Descripción de prueba #' . ($i + 1),
                'idTipo' => rand(1, 9),
                'idEstado' => rand(1, 5),
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
