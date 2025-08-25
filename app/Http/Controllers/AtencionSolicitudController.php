<?php

namespace App\Http\Controllers;

use App\Http\Requests\AsignarTecnicosRequest;
use App\Models\Solicitud;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class AtencionSolicitudController extends Controller
{
    public function asignarTecnicos(AsignarTecnicosRequest $request, string $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        DB::transaction(function () use ($request, $solicitud) {

            User::whereIn('id', $request->personalAtencion)->update(['disponibilidad' => false]);

            $tecnicosData = [];
            foreach ($request->personalAtencion as $idTecnico) {
                $tecnicosData[$idTecnico] = ['estado' => 1];
            }

            $solicitud->personalAtencion()->syncWithoutDetaching($tecnicosData);

            $solicitud->update(['idEstado' => 3]);
        });

        return response()->json(['message' => 'Técnicos asignados correctamente'], 200);
    }

    public function update(AsignarTecnicosRequest $request, string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        DB::transaction(function () use ($request, $solicitud) {
            User::whereIn('id', $solicitud->personalAtencion->pluck('id'))
                ->update(['disponibilidad' => true]);

            $tecnicosData = [];
            foreach ($request->personalAtencion as $idTecnico) {
                $tecnicosData[$idTecnico] = ['estado' => 1];
            }

            $solicitud->personalAtencion()->sync($tecnicosData);

            User::whereIn('id', $request->personalAtencion)
                ->update(['disponibilidad' => false]);
        });

        return response()->json(['message' => 'Los técnicos asignados fueron actualizados correctamente'], 200);
    }


    public function destroy(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        DB::transaction(function () use ($solicitud) {
            $tecnicosActivos = $solicitud->personalAtencion()->wherePivot('estado', 1)->pluck('users.id')->toArray();

            if (!empty($tecnicosActivos)) {
                foreach ($tecnicosActivos as $idTecnico) {
                    $solicitud->personalAtencion()->updateExistingPivot($idTecnico, ['estado' => 0]);
                }
                User::whereIn('id', $tecnicosActivos)->update(['disponibilidad' => true]);
            }
            
            $solicitud->update(['idEstado' => 2]);
        });

        return response()->json(['message' => 'Técnicos liberados correctamente'], 200);
    }


    public function tecnicos()
    {
        $tecnicos = User::with('roles')
            ->where('status', true)
            ->where('disponibilidad', true)
            ->whereHas('roles', function ($query) {
                $query->where('id', '2');
            })
            ->get();
        return response()->json($tecnicos, 200);
    }
}
