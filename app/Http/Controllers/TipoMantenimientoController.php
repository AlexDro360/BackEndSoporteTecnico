<?php

namespace App\Http\Controllers;

use App\Models\TipoMantenimiento;
use Illuminate\Http\Request;

class TipoMantenimientoController extends Controller
{
    public function index()
    {
        $respuestas = TipoMantenimiento::all();
        return response()->json($respuestas, 200);
    }
}
