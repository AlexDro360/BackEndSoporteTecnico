<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Spatie\Permission\Models\Role;
use App\Models\Departamento;
// use Illuminate\Support\Facades\Storage;


class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departamento = Departamento::all();
        $data = [
            'departamento' => $departamento,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function config()
    {
        return response()->json([
            "roles" => Role::all(),
        ]);
    }
}
