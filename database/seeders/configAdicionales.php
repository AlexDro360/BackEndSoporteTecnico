<?php

namespace Database\Seeders;

use App\Models\ConfigAdicionales as ModelsConfigAdicionales;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class configAdicionales extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsConfigAdicionales::create(['FolioRespuesta' => '1', 'FolioSolicitud' => '1']);
    }
}
