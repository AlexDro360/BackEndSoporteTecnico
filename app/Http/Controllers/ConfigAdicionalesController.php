<?php

namespace App\Http\Controllers;

use App\Models\ConfigAdicionales;
use App\Models\Departamento;
use App\Models\Estado;
use Illuminate\Http\Request;

class ConfigAdicionalesController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->get('search');

        $perPage = $request->input('perPage', 10);

        $folios = Departamento::where("nombre", "like", "%" . $search . "%")->paginate($perPage);

        return response()->json($folios);
    }

    public function resetFolioSolicitud(string $id)
    {
        $depto = Departamento::find($id);

        $depto->update(['folio' => 1]);

        return response()->json(['message' => 'Folio de solicitud reiniciado correctamente', 'data' => $depto]);
    }

    public function resetFolioRespuesta(string $id)
    {
        $config = Departamento::where('abreviatura');
        $config->folio = 1;
        $config->save();

        return response()->json(['message' => 'Folio de respuesta reiniciado correctamente', 'data' => $config]);
    }


    public function updateFolios(Request $request, string $id)
    {
        $request->validate([
            'folio' => 'nullable|integer|min:0',
        ]);

        $depto = Departamento::find($id);

        $depto->update([
            'folio' => $request->input('folio', $depto->folio),
        ]);

        return response()->json(['message' => 'Folios actualizados correctamente', 'data' => $depto]);
    }

    public function getEstatus()
    {
        $estatus = Estado::all();
        return response()->json($estatus, 200);
    }
}
