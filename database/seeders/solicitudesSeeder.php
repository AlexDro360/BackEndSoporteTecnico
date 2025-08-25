<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class solicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
{
    $faker = Faker::create('es_MX');

    // Insertar jefes de centro de cómputo
    for ($i = 0; $i < 100; $i++) {
        DB::table('centro_computo_jefes')->insert([
            'nombres'    => $faker->firstName,
            'apellidoP'  => $faker->lastName,
            'apellidoM'  => $faker->lastName,
            'estado'     => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    $folioRespuesta = 1;
    $tecnicos = User::whereHas('role', function ($q) {
        $q->where('name', 'Técnico');
    })->pluck('id')->toArray();

    for ($i = 0; $i < 1000; $i++) {
        $randomDate = Carbon::now()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
        $estado = rand(1, 6); // Estados: Recibida (1) a Finalizada (6)

        $solicitudId = DB::table('solicituds')->insertGetId([
            'folio' => $i + 1,
            'idUser' => rand(2, 50),
            'descripcionUser' => 'Descripción de prueba #' . ($i + 1),
            'idTipo' => rand(1, 9),
            'idEstado' => $estado,
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ]);

        // Técnicos desde estado 3 en adelante
        if ($estado >= 3 && count($tecnicos) >= 2) {
            $atencionUsers = $faker->randomElements($tecnicos, rand(2, 3));
            foreach ($atencionUsers as $techId) {
                DB::table('atencion_solicituds')->insert([
                    'user_id' => $techId,
                    'solicitud_id' => $solicitudId,
                    // 'fechaAtencion' => $randomDate->format('Y-m-d'),
                    // 'horaAtencion' => $randomDate->format('H:i:s'),
                    'estado' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Bitácora si solucionada (estado 5)
        if ($estado == 5) {
            DB::table('bitacoras')->insert([
                'fecha' => $randomDate,
                'descFalla' => $faker->sentence(5),
                'descSolucion' => $faker->sentence(6),
                'materialReq' => $faker->words(3, true),
                'duracion' => rand(1, 8),
                'idSolicitud' => $solicitudId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Respuesta si rechazada (2) o finalizada (6)
        if (in_array($estado, [2, 6])) {
            DB::table('respuestas')->insert([
                'asunto' => $faker->sentence(3),
                'descripcion' => $faker->paragraph(2),
                'fecha' => $randomDate,
                'nombreVerifico' => $faker->name,
                'folio' => $folioRespuesta++,
                'idCentroComputoJefe' => rand(1, 10),
                'idTipoMantenimiento' => rand(1, 2),
                'idTipoServicio' => rand(1, 2),
                'idSolicitud' => $solicitudId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

}
