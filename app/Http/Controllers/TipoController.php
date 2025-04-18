<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::all();

        return response()->json([
            "tipos" => $tipos->map(function ($tipo) {
                return [
                    "id" => $tipo->id,
                    'nombre' => $tipo->nombre,
                ];
            }),
        ]);
    }
}
