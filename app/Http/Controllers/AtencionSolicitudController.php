<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Http\Request;

class AtencionSolicitudController extends Controller
{
    public function asignarTecnicos(Request $request, string $id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json(['message' => 'No se encontro la solicitud indicada'], 404);
        }
        if (!is_array($request->personalAtencion)) {
            return response()->json(['message' => 'La información de técnicos no es válida'], 400);
        }
        $solicitud->personalAntencion()->sync($request->personalAtencion);

        $solicitud->update(['idEstado' => 3]);

        return response()->json(['message' => 'Técnicos asignados correctamente'], 200);
    }

    public function update(Request $request, string $id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json(['message' => 'No se encontro la solicitud indicada'], 404);
        }
        if (!is_array($request->personalAtencion)) {
            return response()->json(['message' => 'La información de técnicos no es válida'], 400);
        }
        $solicitud->personalAntencion()->sync($request->personalAtencion);

        return response()->json(['message' => 'Los técnicos asignados fueron actualizados correctamente'], 200);
    }

    public function destroy(Request $request, string $id)
    {
        $solicitud = Solicitud::find($id);
        if (!$solicitud) {
            return response()->json(['message' => 'No se encontro la solicitud indicada'], 404);
        }
        if (!is_array($request->personalAtencion)) {
            return response()->json(['message' => 'La información de técnicos no es válida'], 400);
        }
        $solicitud->personalAntencion()->detach($request->personalAtencion);

        return response()->json(['message' => 'Técnicos desasignados correctamente'], 200);
    }

    public function tecnicos()
    {
        $tecnicos = User::with('roles')
            ->where('status', true)
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Técnico');
            })
            ->get();
        return response()->json($tecnicos, 200);
    }
}
