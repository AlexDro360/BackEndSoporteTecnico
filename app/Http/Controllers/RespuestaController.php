<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRespuestaRequest;
use App\Http\Requests\UpdateRespuestaRequest;
use App\Models\ConfigAdicionales;
use App\Models\Departamento;
use App\Models\Respuesta;
use App\Models\Solicitud;
use App\Services\PdfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use DB;
use Storage;

class RespuestaController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService; 
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $respuestas = Respuesta::with('tipoServicio', 'tipoMantenimiento', 'solicitud')->paginate($perPage);
        
        return response()->json($respuestas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRespuestaRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use (&$data, $request) {

            $FolioRespuesta = ConfigAdicionales::lockForUpdate()->first();

            $data['folio'] = $FolioRespuesta->FolioRespuesta;
            $data['fecha'] = Carbon::now()->toDateString();
            
            $FolioRespuesta->increment('FolioRespuesta');
            
            $respuesta = Respuesta::create($data);
            
            $urlPdf = $this->pdfService->generarPdf('respuesta',['data' => $respuesta], 'respuesta', 'pdfsRespuestas');

            $respuesta->update(['path_pdf' => $urlPdf]);
            
            $solicitud = Solicitud::findOrFail($request->idSolicitud);
            if ($solicitud->idEstado != 2) {
                $solicitud->update(['idEstado' => 6]);
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
     * Update the specified resource in storage.
     */
    public function update(UpdateRespuestaRequest $request, string $id)
    {
        $respuesta = Respuesta::find($id);

        if (!$respuesta) {
            return response()->json(['message' => 'No se encontro la respuesta'], 404);
        }
        
        $respuesta->fill($request->validated());

        $respuesta->path_pdf = $this->pdfService->generarPdf('respuesta', $respuesta->toArray(), 'respuesta', 'pdfsRespuestas');

        $respuesta->save();

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



    public function obtenerPDF($id)
    {
        $respuesta = Respuesta::find($id);

        if(!$respuesta || !Storage::disk('pdfsRespuestas')->exists($respuesta->path_pdf)){
            return response()->json(['error'=>'Archivo no encontrado'], 404);
        }
        
        return response()->file(
            Storage::disk('pdfsRespuestas')->path($respuesta->path_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Respuesta'.$respuesta->id.'.pdf"'
            ]
        );
    }

    
}
