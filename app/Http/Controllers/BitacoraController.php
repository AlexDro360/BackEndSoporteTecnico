<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBitacoraRequest;
use App\Http\Requests\UpdateBitacoraRequest;
use App\Models\Bitacora;
use App\Models\Solicitud;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class BitacoraController extends Controller
{
    //

    public function index(Request $request)
    {
        $search = $request->get("search");
        $perPage = $request->input('perPage', 10);

        $bitacoras = Bitacora::with([
            'solicitud.user.departamento',
            'solicitud.tipo',
            'solicitud.personalAtencion' => function ($query) {
                $query->wherePivot('estado', 1);
            }
        ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas("solicitud", function ($q) use ($search) {
                    $q->where("folio", "like", "%{$search}%");
                });
            })
            ->orderByDesc("id")
            ->paginate($perPage);

        if ($bitacoras->isEmpty()) {
            return response()->json(['message' => 'No hay bitacoras'], 404);
        }
        return response()->json($bitacoras, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBitacoraRequest $request)
    {

        DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['fecha'] = Carbon::now()->toDateString();

            $idTipoNuevo = $data['idTipo'];
            unset($data['idTipo']);

            Bitacora::create($data);

            $solicitud = Solicitud::with('personalAtencion')->findOrFail($request->idSolicitud);
            $solicitud->update(['idEstado' => 5, 'idTipo' => $idTipoNuevo]);

            $ids = $solicitud->personalAtencion->pluck('id');
            User::whereIn('id', $ids)->update(['disponibilidad' => true]);
        });
        return response()->json(['message'   => 'Bitácora agregada exitosamente',], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bitacoras = Bitacora::with('solicitud')->find($id);
        if (!$bitacoras) {
            return response()->json(['message' => 'No se encontro la bitácora'], 404);
        }
        return response()->json($bitacoras, 200);
    }

    public function getBitacora(string $id)
    {
        $bitacora = Bitacora::with([
            'solicitud.user.departamento',
            'solicitud.tipo',
            'solicitud.personalAtencion' => function ($query) {
                $query->wherePivot('estado', 1);
            }
        ])->firstWhere('idSolicitud', $id);

        if (!$bitacora) {
            return response()->json([
                'message' => 'No se encontró una bitácora para esta solicitud.'
            ], 404);
        }

        return response()->json($bitacora);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBitacoraRequest $request, string $id)
    {
        DB::transaction(function () use ($request, $id) {
            $data = $request->validated();

            $idTipoNuevo = $data['idTipo'];
            unset($data['idTipo']);
            $data['fecha'] = now()->toDateString();

            $bitacora = Bitacora::findOrFail($id);

            $bitacora->update($data);

            $bitacora->solicitud->update(['idTipo' => $idTipoNuevo]);
        });
        return response()->json(['message' => 'Bitácora actualizada exitosamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bitacora = Bitacora::find($id);
        if (!$bitacora) {
            return response()->json(['message' => 'No se encontro la Bitacora'], 404);
        }
        $bitacora->delete();
        return response()->json(['message' => 'Bitacora eliminada correctamente'], 200);
    }
}
