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


    public function EditFolioRespuesta(Request $request)
    {
        $request->validate([
            'folio' => 'nullable|integer|min:0',
        ]);
        $config = ConfigAdicionales::first();
        $config->update(['FolioRespuesta' => $request->input('folio', $config->FolioRespuesta)]);

        return response()->json(['message' => 'Folio de respuesta reiniciado correctamente', 'data' => $config]);
    }

    public function updateFolioRespuesta(Request $request)
{
    try {
        $config = ConfigAdicionales::first(); // O busca por ID si es por registro específico

        if (!$config) {
            return response()->json(['error' => 'No se encontró configuración'], 404);
        }

        $config->FolioRespuesta = $request->FolioRespuesta;
        $config->save();

        return response()->json(['message' => 'Folio de respuesta actualizado correctamente']);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
}

public function resetFolioRespuesta()
    {
        try {
            $config = ConfigAdicionales::first(); 

            if (!$config) {
                return response()->json(['error' => 'No se encontró configuración'], 404);
            }

            $config->FolioRespuesta = 1;
            $config->save();

            return response()->json([
                'message' => 'Folio de respuesta reseteado correctamente',
                'folio_respuesta' => $config->FolioRespuesta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function getFolioRespuesta()
    {
        try {
            $config = ConfigAdicionales::first();

            if (!$config) {
                return response()->json([
                    'error' => 'No se encontró la configuración'
                ], 404);
            }

            return response()->json([
                'folio_respuesta' => $config->FolioRespuesta
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener el folio',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

}
