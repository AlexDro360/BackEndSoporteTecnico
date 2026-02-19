<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolicitudRequest;
use App\Models\Bitacora;
use App\Models\ConfigAdicionales;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Solicitud;
use App\Models\User;
use App\Services\PdfService;
use DB;
use Storage;

use function PHPUnit\Framework\isEmpty;

class SolicitudController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }


    public function index(Request $request)
    {
        $search = $request->get("search");
        $estatus = $request->input('filtroEstatus', 0);
        $perPage = $request->input('perPage', 10);

        $solicitudes = Solicitud::with(['user.departamento', 'respuesta'])
            ->when($search, function ($query) use ($search) {
                $query->where("folio", "like", "%{$search}%");
            })
            ->when($estatus > 0, function ($query) use ($estatus) {
                $query->where("idEstado", $estatus);
            })
            ->orderByDesc("id")
            ->paginate($perPage);


        return response()->json([
            "total" => $solicitudes->total(),
            "solicitudes" => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                    ] : null,
                    'estado' => $solicitud->estado ? [
                        'id' => $solicitud->estado->id,
                        'nombre' => $solicitud->estado->nombre,
                    ] : null,
                    'tipo' => $solicitud->tipo ? [
                        'id' => $solicitud->tipo->id,
                        'nombre' => $solicitud->tipo->nombre,
                    ] : null,
                    'id' => $solicitud->id,
                    'folio' => $solicitud->folio,
                    'descripcionUser' => $solicitud->descripcionUser,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);


        // return response()->json([
        //     "total" => $solicitudes->total(),
        //     "solicitudes" => $solicitudes->map(function ($solicitud) {
        //         return [
        //             'user' => $solicitud->user ? [
        //                 'id' => $solicitud->user->id,
        //                 'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
        //                 'email' => $solicitud->user->email,
        //                 'phone' => $solicitud->user->phone,
        //                 'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
        //                 'departamentoC' => $solicitud->user->departamento,
        //                 'num_empleado' => $solicitud->user->num_empleado,
        //                 'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
        //             ] : null,
        //             'estado' => $solicitud->estado ? [
        //                 'id' => $solicitud->estado->id,
        //                 'nombre' => $solicitud->estado->nombre,
        //             ] : null,
        //             'tipo' => $solicitud->tipo ? [
        //                 'id' => $solicitud->tipo->id,
        //                 'nombre' => $solicitud->tipo->nombre,
        //             ] : null,
        //             'id' => $solicitud->id,
        //             'folio' => $solicitud->folio,
        //             'descripcionUser' => $solicitud->descripcionUser,
        //             'fechaAsignacion' => $solicitud->fechaAsignacion,
        //             'fechaRevision' => $solicitud->fechaRevision,
        //             'descripcionFalla' => $solicitud->descripcionFalla,
        //             'fechaSolucion' => $solicitud->fechaSolucion,
        //             'descripcionSolucion' => $solicitud->descripcionSolucion,
        //             'descripcionRechazo' => $solicitud->descripcionRechazo,
        //             'idTipo' => $solicitud->idTipo,
        //             'idEstado' => $solicitud->idEstado,
        //             'respuesta' => $solicitud->respuesta ? true : false,
        //             'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
        //             'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
        //         ];
        //     }),
        // ]);
    }

    public function misSolicitudes(Request $request, string $id)
    {
        $search = $request->get('search');

        $perPage = $request->input('perPage', 10);

        $solicitudes = Solicitud::with('user', 'respuesta', 'estado', 'tipo')
            ->where('idUser', $id)
            ->when($search, function ($query, $search) {
                $query->where('folio', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            "total" => $solicitudes->total(),
            "solicitudes" => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                    ] : null,
                    'estado' => $solicitud->estado ? [
                        'id' => $solicitud->estado->id,
                        'nombre' => $solicitud->estado->nombre,
                    ] : null,
                    'tipo' => $solicitud->tipo ? [
                        'id' => $solicitud->tipo->id,
                        'nombre' => $solicitud->tipo->nombre,
                    ] : null,
                    'id' => $solicitud->id,
                    'folio' => $solicitud->folio,
                    'descripcionUser' => $solicitud->descripcionUser,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);


        // return response()->json([
        //     "total" => $solicitudes->total(),
        //     "solicitudes" => $solicitudes->map(function ($solicitud) {
        //         return [
        //             'user' => $solicitud->user ? [
        //                 'id' => $solicitud->user->id,
        //                 'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
        //                 'email' => $solicitud->user->email,
        //                 'phone' => $solicitud->user->phone,
        //                 'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
        //                 'departamentoC' => $solicitud->user->departamento,
        //                 'num_empleado' => $solicitud->user->num_empleado,
        //                 'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
        //             ] : null,
        //             'estado' => $solicitud->estado ? [
        //                 'id' => $solicitud->estado->id,
        //                 'nombre' => $solicitud->estado->nombre,
        //             ] : null,
        //             'tipo' => $solicitud->tipo ? [
        //                 'id' => $solicitud->tipo->id,
        //                 'nombre' => $solicitud->tipo->nombre,
        //             ] : null,
        //             'id' => $solicitud->id,
        //             'folio' => $solicitud->folio,
        //             'descripcionUser' => $solicitud->descripcionUser,
        //             'fechaAsignacion' => $solicitud->fechaAsignacion,
        //             'fechaRevision' => $solicitud->fechaRevision,
        //             'descripcionFalla' => $solicitud->descripcionFalla,
        //             'fechaSolucion' => $solicitud->fechaSolucion,
        //             'descripcionSolucion' => $solicitud->descripcionSolucion,
        //             'descripcionRechazo' => $solicitud->descripcionRechazo,
        //             'idTipo' => $solicitud->idTipo,
        //             'idEstado' => $solicitud->idEstado,
        //             'respuesta' => $solicitud->respuesta ? true : false,
        //             'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
        //             'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
        //         ];
        //     }),
        // ]);
    }

    public function misSolicitudesAtendidas(Request $request, string $id)
    {
        $search = $request->get('search');

        $perPage = $request->input('perPage', 10);

        $solicitudes = Solicitud::with(['personalAtencion', 'user', 'respuesta', 'estado', 'tipo'])
            ->whereHas('personalAtencion', function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->where('atencion_solicituds.estado', 1);
            })
            // ->whereHas('personalAtencion', function ($q) use ($id) {
            //     $q->where('user_id', $id);
            // })
            ->when($search, function ($query, $search) {
                $query->where('folio', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            "total" => $solicitudes->total(),
            "solicitudes" => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
                    ] : null,
                    'estado' => $solicitud->estado ? [
                        'id' => $solicitud->estado->id,
                        'nombre' => $solicitud->estado->nombre,
                    ] : null,
                    'tipo' => $solicitud->tipo ? [
                        'id' => $solicitud->tipo->id,
                        'nombre' => $solicitud->tipo->nombre,
                    ] : null,
                    'id' => $solicitud->id,
                    'folio' => $solicitud->folio,
                    'descripcionUser' => $solicitud->descripcionUser,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);



        // return response()->json([
        //     "total" => $solicitudes->total(),
        //     "solicitudes" => $solicitudes->map(function ($solicitud) {
        //         return [
        //             'user' => $solicitud->user ? [
        //                 'id' => $solicitud->user->id,
        //                 'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
        //                 'email' => $solicitud->user->email,
        //                 'phone' => $solicitud->user->phone,
        //                 'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
        //                 'departamentoC' => $solicitud->user->departamento,
        //                 'num_empleado' => $solicitud->user->num_empleado,
        //                 'avatar' => $solicitud->user->avatar ? asset("storage/" . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
        //             ] : null,
        //             'estado' => $solicitud->estado ? [
        //                 'id' => $solicitud->estado->id,
        //                 'nombre' => $solicitud->estado->nombre,
        //             ] : null,
        //             'tipo' => $solicitud->tipo ? [
        //                 'id' => $solicitud->tipo->id,
        //                 'nombre' => $solicitud->tipo->nombre,
        //             ] : null,
        //             'id' => $solicitud->id,
        //             'folio' => $solicitud->folio,
        //             'descripcionUser' => $solicitud->descripcionUser,
        //             'fechaAsignacion' => $solicitud->fechaAsignacion,
        //             'fechaRevision' => $solicitud->fechaRevision,
        //             'descripcionFalla' => $solicitud->descripcionFalla,
        //             'fechaSolucion' => $solicitud->fechaSolucion,
        //             'descripcionSolucion' => $solicitud->descripcionSolucion,
        //             'descripcionRechazo' => $solicitud->descripcionRechazo,
        //             'idTipo' => $solicitud->idTipo,
        //             'idEstado' => $solicitud->idEstado,
        //             'respuesta' => $solicitud->respuesta ? true : false,
        //             'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
        //             'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
        //         ];
        //     }),
        // ]);
    }


    public function config() {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSolicitudRequest $request)
    {
        DB::transaction(function () use (&$request) {

            $usuario = User::with('departamento')->find($request->idUser);
            $departamento = $usuario->departamento;

            $data = $request->validated();
            $data['idEstado'] = 1;
            $data['folio'] = $departamento->folio;

            $solicitud = Solicitud::create($data);

            $departamento->increment('folio');

            $urlPdf =  $this->pdfService->generarPdf('solicitud', ['data' => $solicitud], 'solicitud', 'pdfsSolicitudes');

            $solicitud->update(['path_pdf' => $urlPdf]);
        });

        return response()->json(['message' => 'Solicitud agregada exitosamente'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $solicitud = Solicitud::with('user', 'estado', 'tipo')->find($id);
        if (!$solicitud) {
            return response()->json(['message' => 'No se encontro la solicitud'], 404);
        }
        return response()->json($solicitud, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solicitud = Solicitud::findOrFail($id);
        // if ($solicitud->idEstado != 1 && $solicitud->idEstado != 2) {
        //     return response()->json([
        //         "message" => "No se puede editar esta solicitud porque ya no está pendiente.",
        //         "code" => 403
        //     ], 403);
        // }

        return DB::transaction(function () use ($solicitud, $request) {

            $solicitud->fill($request->all());

            $solicitud->idEstado = 1;

            $urlPdf =  $this->pdfService->generarPdf('solicitud', ['data' => $solicitud], 'solicitud', 'pdfsSolicitudes');
            $solicitud->path_pdf = $urlPdf;

            $solicitud->save();

            return response()->json([
                "message" => 200,
                "user" => [
                    "id" => $solicitud->id,
                    'descripcion' => $solicitud->descripcion,
                    'idBitacora' => $solicitud->idBitacora,
                    'idUser' => $solicitud->idUser,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                ]
            ]);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update(['idEstado' => 5]);

        return response()->json([
            "message" => 200,
            "message_text" => "La Solicitud se Terminó"
        ]);
    }

    public function rechazar(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update(['idEstado' => 2]);

        return response()->json([
            "message" => 200,
            "message_text" => "La Solicitud se Rechazó"
        ]);
    }

    public function obtenerPDF($id)
    {
        $solicitud = Solicitud::find($id);

        if (!$solicitud || !Storage::disk('pdfsSolicitudes')->exists($solicitud->path_pdf)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->file(
            Storage::disk('pdfsSolicitudes')->path($solicitud->path_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Solicitud_' . $solicitud->id . '.pdf"'
            ]
        );
    }

    public function noSolucionada(string $id)
    {
        DB::transaction(function () use ($id) {

            $solicitud = Solicitud::with('personalAtencion')->findOrFail($id);

            $solicitud->update(['idEstado' => 4]);

            $tecnicosAtendieron = $solicitud->personalAtencion()->wherePivot('estado', 1)->get();
            $idsTecnicos = $tecnicosAtendieron->pluck('id');

            User::whereIn('id', $idsTecnicos)->update(['disponibilidad' => true]);

            foreach ($idsTecnicos as $idTecnico) {
                $solicitud->personalAtencion()->updateExistingPivot($idTecnico, ['estado' => 0]);
            }
        });

        return response()->json([
            "message" => 200,
            "message_text" => "La solicitud se asignó como no solucionada"
        ]);
    }
}
