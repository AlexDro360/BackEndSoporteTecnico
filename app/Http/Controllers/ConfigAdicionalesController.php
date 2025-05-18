<?php

namespace App\Http\Controllers;

use App\Models\ConfigAdicionales;
use Illuminate\Http\Request;

class ConfigAdicionalesController extends Controller
{
    public function show()
    {
        $config = ConfigAdicionales::first();
        return response()->json($config);
    }

    public function resetFolioSolicitud()
    {
        $config = ConfigAdicionales::first();
        $config->FolioSolicitud = 1;
        $config->save();

        return response()->json(['message' => 'Folio de solicitud reiniciado correctamente', 'data' => $config]);
    }

    public function resetFolioRespuesta()
    {
        $config = ConfigAdicionales::first();
        $config->FolioRespuesta = 1;
        $config->save();

        return response()->json(['message' => 'Folio de respuesta reiniciado correctamente', 'data' => $config]);
    }

    
    public function updateFolios(Request $request)
    {
        $request->validate([
            'FolioSolicitud' => 'nullable|integer|min:0',
            'FolioRespuesta' => 'nullable|integer|min:0',
        ]);

        $config = ConfigAdicionales::first();
        $config->update([
            'FolioSolicitud' => $request->input('FolioSolicitud', $config->FolioSolicitud),
            'FolioRespuesta' => $request->input('FolioRespuesta', $config->FolioRespuesta),
        ]);

        return response()->json(['message' => 'Folios actualizados correctamente', 'data' => $config]);
    }
}
