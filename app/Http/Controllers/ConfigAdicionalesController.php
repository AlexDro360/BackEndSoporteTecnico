<?php

namespace App\Http\Controllers;

use App\Models\ConfigAdicionales;
use App\Models\Departamento;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfigAdicionalesController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->get('search');

        $perPage = $request->input('perPage', 10);

        $folios = Departamento::where("nombre", "like", "%" . $search . "%")->paginate($perPage);

        return response()->json($folios);
    }

    public function showMyFolio(String $id)
    {
        $folioDepto = Departamento::find($id);

        return response()->json($folioDepto);
    }


    public function resetFolioSolicitud(string $id)
    {
        $depto = Departamento::findOrFail($id);
        $user = Auth::user();

        return DB::transaction(function () use ($depto, $user) {
            if ($user->hasRole(3)) {
                if ($depto->numIntentosEditarFolio <= 0) {
                    return response()->json([
                        'message' => 'No tienes intentos restantes para realizar esta acción.'
                    ], 403);
                }
                $depto->decrement('numIntentosEditarFolio');
            }

            $depto->update(['folio' => 1]);

            return response()->json([
                'message' => 'Folio de solicitud reiniciado correctamente',
                'data' => $depto->refresh()
            ]);
        });
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
            $config = ConfigAdicionales::first();

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

        $depto = Departamento::findOrFail($id);
        $user = Auth::user();
        $nuevoFolio = $request->input('folio', $depto->folio);

        if ($depto->folio == $nuevoFolio) {
            return response()->json(['message' => 'No hubo cambios en el folio', 'data' => $depto]);
        }

        return DB::transaction(function () use ($depto, $user, $nuevoFolio) {

            if ($user->hasRole(3)) {
                if ($depto->numIntentosEditarFolio <= 0) {
                    return response()->json([
                        'message' => 'No tienes intentos restantes para realizar esta acción.'
                    ], 403);
                }

                $depto->decrement('numIntentosEditarFolio');
            }

            $depto->update([
                'folio' => $nuevoFolio,
            ]);

            return response()->json([
                'message' => 'Folios actualizados correctamente',
                'data' => $depto->refresh()
            ]);
        });
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
