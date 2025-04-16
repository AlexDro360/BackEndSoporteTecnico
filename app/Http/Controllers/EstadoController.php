<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Estado::all();

        return response()->json([
            "estados" => $estados->map(function ($estado) {
                return [
                    "id" => $estado->id,
                    'nombre' => $estado->nombre,
                ];
            }),
        ]);
    }
}
