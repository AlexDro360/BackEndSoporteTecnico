<?php

namespace App\Http\Controllers;

use App\Models\TipoServicio;
use Illuminate\Http\Request;

class TipoServicioController extends Controller
{
    public function index()
    {
        $respuestas = TipoServicio::all();
        return response()->json($respuestas, 200);
    }
}
