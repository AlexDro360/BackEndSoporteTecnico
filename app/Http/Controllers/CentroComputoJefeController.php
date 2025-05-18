<?php

namespace App\Http\Controllers;

use App\Models\CentroComputoJefe;
use Illuminate\Http\Request;

class CentroComputoJefeController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $jefes = CentroComputoJefe::orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json($jefes, 200);
    }

    public function jefeActivo()
    {
        $jefe = CentroComputoJefe::where('estado', true)->first();

        if ($jefe) {
            $jefe->nombreC = $jefe->nombres . ' ' . $jefe->apellidoP . ' ' . $jefe->apellidoM;
        }

        return response()->json($jefe, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombres'    => 'required|string|max:50',
            'apellidoP'  => 'required|string|max:50',
            'apellidoM'  => 'required|string|max:50',
        ]);

        CentroComputoJefe::where('estado', true)->update(['estado' => false]);

        $validated['estado'] = true;
        $jefe = CentroComputoJefe::create($validated);
        return response()->json($jefe, 201);
    }

    public function show($id)
    {
        $jefe = CentroComputoJefe::find($id);

        if (!$jefe) {
            return response()->json(['message' => 'No encontrado'], 404);
        }

        return response()->json($jefe);
    }

    public function update(Request $request, $id)
    {
        $jefe = CentroComputoJefe::find($id);

        if (!$jefe) {
            return response()->json(['message' => 'Jefe no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombres'    => 'sometimes|string|max:50',
            'apellidoP'  => 'sometimes|string|max:50',
            'apellidoM'  => 'sometimes|string|max:50',
            'estado'     => 'sometimes|boolean',
        ]);

        if ($request->estado && $request->estado != $jefe->estado) {
            CentroComputoJefe::where('estado', true)->update(['estado' => false]);
        }

        $jefe->update($validated);

        return response()->json($jefe);
    }

    public function destroy($id)
    {
        $jefe = CentroComputoJefe::find($id);

        if (!$jefe) {
            return response()->json(['message' => 'Jefe no encontrado'], 404);
        }

        $jefe->estado = false;
        $jefe->save();

        return response()->json(['message' => 'Jefe dado de baja correctamente']);
    }
}
