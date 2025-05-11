<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class BitacoraController extends Controller
{
    //

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $bitacoras = Bitacora::with('solicitud')->paginate($perPage);
        if ($bitacoras->isEmpty()) {
            return response()->json(['message' => 'No hay bitacoras'], 404);
        }
        return response()->json($bitacoras, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descFalla' => 'required|string|max:200',
            'descSolucion' => 'required|string|max:200',
            'materialReq' => 'required|string|max:200',
            'idSolicitud' => 'required|exists:solicituds,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['fecha'] = Carbon::now()->toDateString();

        Bitacora::create($data);

        $solicitud = Solicitud::findOrFail($request->idSolicitud);

        $solicitud->update(['idEstado' => 4]);

        return response()->json(['message' => 'Bitacora agregada exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $bitacoras = Bitacora::with('solicitud')->find($id);
        if (!$bitacoras) {
            return response()->json(['message' => 'No se encontro la bitacora'], 404);
        }
        return response()->json($bitacoras, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bitacora = Bitacora::find($id);
        if (!$bitacora) {
            return response()->json(['message' => 'No se encontro la bitacora'], 404);
        }
        $validator = Validator::make($request->all(), [
            'descFalla' => 'sometimes|string|max:200',
            'descSolucion' => 'sometimes|string|max:200',
            'materialReq' => 'sometimes|string|max:200',
            'idSolicitud' => 'sometimes|exists:solicituds,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($request->has('descFalla')) {
            $bitacora->descFalla = $request->descFalla;
        }
        if ($request->has('descSolucion')) {
            $bitacora->descSolucion = $request->descSolucion;
        }
        if ($request->has('materialReq')) {
            $bitacora->materialReq = $request->materialReq;
        }
        if ($request->has('idSolicitud')) {
            $bitacora->idSolicitud = $request->idSolicitud;
        }

        $bitacora->fecha = Carbon::now()->toDateString();

        $bitacora->update();

        return response()->json(['message' => 'Bitacora actualizada exitosamente'], 200);
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
