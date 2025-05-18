<?php

namespace App\Http\Controllers;

use App\Models\ConfigAdicionales;
use App\Models\Respuesta;
use App\Models\Solicitud;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DB;

class RespuestaController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $respuestas = Respuesta::with('tipoServicio', 'tipoMantenimiento', 'solicitud')->paginate($perPage);
        // if ($respuestas->isEmpty()) {
        //     return response()->json(['message' => 'No hay respuestas'], 404);
        // }
        return response()->json($respuestas, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asunto' => 'required|string|max:100',
            'descripcion' => 'required|string|max:500',
            'nombreVerifico' => 'required|string|max:150',
            'idCentroComputoJefe' => 'required|exists:centro_computo_jefes,id',
            'idTipoMantenimiento' => 'sometimes|exists:tipo_mantenimientos,id',
            'idTipoServicio' => 'sometimes|exists:tipo_servicios,id',
            'idSolicitud' => 'required|exists:solicituds,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $validator->validated();
        DB::transaction(function () use (&$data, &$request) {

            $confAd = ConfigAdicionales::lockForUpdate()->first();

            $data['folio'] = $confAd->FolioRespuesta;
            $data['fecha'] = Carbon::now()->toDateString();

            $confAd->FolioRespuesta ++;
            $confAd->save();

            Respuesta::create($data);

            $solicitud = Solicitud::findOrFail($request->idSolicitud);
            if ($solicitud->idEstado != 2) {
                $solicitud->update(['idEstado' => 5]);
            }
        });

        return response()->json(['message' => 'Respuesta agregada exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $respuestas = Respuesta::with('tipoServicio', 'tipoMantenimiento', 'solicitud')->find($id);
        if (!$respuestas) {
            return response()->json(['message' => 'No se encontro la respuesta'], 404);
        }
        return response()->json($respuestas, 200);
    }



    public function getRespuesta(string $id)
    {
        $respuestas = Respuesta::with('tipoServicio', 'tipoMantenimiento', 'solicitud', 'aprobo')->where('idSolicitud', '=', $id)->first();
        if (!$respuestas) {
            return response()->json(['message' => 'No se encontro la respuesta'], 404);
        }

        return response()->json($respuestas, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $respuesta = Respuesta::find($id);
        if (!$respuesta) {
            return response()->json(['message' => 'No se encontro la respuesta'], 404);
        }
        $validator = Validator::make($request->all(), [
            'asunto' => 'sometimes|string|max:100',
            'descripcion' => 'sometimes|string|max:500',
            'nombreVerifico' => 'sometimes|string|max:150',
            'idCentroComputoJefe' => 'sometimes|exists:centro_computo_jefes,id',
            'idTipoMantenimiento' => 'sometimes|exists:tipo_mantenimientos,id',
            'idTipoServicio' => 'sometimes|exists:tipo_servicios,id',
            'idSolicitud' => 'sometimes|exists:solicituds,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        if ($request->has('asunto')) {
            $respuesta->asunto = $request->asunto;
        }
        if ($request->has('descripcion')) {
            $respuesta->descripcion = $request->descripcion;
        }
        if ($request->has('nombreVerifico')) {
            $respuesta->nombreVerifico = $request->nombreVerifico;
        }
        if ($request->has('idtipoMantenimiento')) {
            $respuesta->idtipoMantenimiento = $request->idtipoMantenimiento;
        }
        if ($request->has('idTipoServicio')) {
            $respuesta->idTipoServicio = $request->idTipoServicio;
        }
        if ($request->has('idSolicitud')) {
            $respuesta->idSolicitud = $request->idSolicitud;
        }

        $respuesta->fecha = Carbon::now()->toDateString();

        $respuesta->update();

        return response()->json(['message' => 'Resuesta actualizada exitosamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $respuesta = Respuesta::find($id);
        if (!$respuesta) {
            return response()->json(['message' => 'No se encontro la Respuesta'], 404);
        }
        $respuesta->delete();
        return response()->json(['message' => 'Respuesta eliminada correctamente'], 200);
    }

    public function generarPDF($id)
    {
        $respuesta = Respuesta::with('tipoServicio', 'tipoMantenimiento', 'solicitud.user.departamento', 'solicitud.personalAtencion', 'aprobo')->find($id);
        if (!$respuesta) {
            return response()->json(['message' => 'No se encontro la Respuesta'], 404);
        }
        $pdf = PDF::loadView('respuesta', ['respuesta' => $respuesta]);
        return $pdf->stream();
    }
}
