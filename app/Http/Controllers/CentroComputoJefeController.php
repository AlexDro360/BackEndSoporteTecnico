<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJefeRequest;
use App\Models\CentroComputoJefe;
use DB;
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

    public function store(StoreJefeRequest $request)
    {
        $validated = $request->validated();
        $jefe = DB::transaction(function () use ($validated) {
            CentroComputoJefe::where('estado', true)->update(['estado' => false]);
            $validated['estado'] = true;
            return CentroComputoJefe::create($validated);
        });
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
        $jefe = CentroComputoJefe::findOrFail($id);

        $validated = $request->validated();

        $jefe = DB::transaction(function () use ($jefe, $validated) {

            if (isset($validated['estado']) && $validated['estado'] && $validated['estado'] != $jefe->estado) {
                CentroComputoJefe::where('estado', true)->update(['estado' => false]);
            }

            $jefe->update($validated);

            return $jefe;
        });

        return response()->json($jefe, 200);
    }

    public function destroy($id)
    {
        $jefe = CentroComputoJefe::find($id);

        if (!$jefe) {
            return response()->json(['message' => 'Jefe no encontrado'], 404);
        }

        $jefe->update(['estado' => false]);

        return response()->json(['message' => 'Jefe dado de baja correctamente'], 200);
    }
}
