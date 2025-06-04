<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\ConfigAdicionales;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Solicitud;
use App\Models\User;
use DB;

use function PHPUnit\Framework\isEmpty;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");

        $estatus = $request->input('filtroEstatus', 0);

        $perPage = $request->input('perPage', 10);

        if ($estatus > 0) {
            $solicitudes = Solicitud::with('user', 'respuesta')
                ->where("folio", "like", "%" . $search . "%")
                ->where("idEstado", "=", $estatus)
                ->orderBy("id", "desc")
                ->paginate($perPage);
        } else {
            $solicitudes = Solicitud::with('user', 'respuesta')
                ->where("folio", "like", "%" . $search . "%")
                ->orderBy("id", "desc")
                ->paginate($perPage);
        }


        return response()->json([
            "total" => $solicitudes->total(),
            "solicitudes" => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
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
                    'fechaAsignacion' => $solicitud->fechaAsignacion,
                    'fechaRevision' => $solicitud->fechaRevision,
                    'descripcionFalla' => $solicitud->descripcionFalla,
                    'fechaSolucion' => $solicitud->fechaSolucion,
                    'descripcionSolucion' => $solicitud->descripcionSolucion,
                    'descripcionRechazo' => $solicitud->descripcionRechazo,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);
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
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
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
                    'fechaAsignacion' => $solicitud->fechaAsignacion,
                    'fechaRevision' => $solicitud->fechaRevision,
                    'descripcionFalla' => $solicitud->descripcionFalla,
                    'fechaSolucion' => $solicitud->fechaSolucion,
                    'descripcionSolucion' => $solicitud->descripcionSolucion,
                    'descripcionRechazo' => $solicitud->descripcionRechazo,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);
    }

    public function misSolicitudesAtendidas(Request $request, string $id)
    {
        $search = $request->get('search');

        $perPage = $request->input('perPage', 10);

        $solicitudes = Solicitud::with(['personalAtencion', 'user', 'respuesta', 'estado', 'tipo'])
            ->whereHas('personalAtencion', function ($q) use ($id) {
                $q->where('user_id', $id);
            })
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
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surname,
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
                    'fechaAsignacion' => $solicitud->fechaAsignacion,
                    'fechaRevision' => $solicitud->fechaRevision,
                    'descripcionFalla' => $solicitud->descripcionFalla,
                    'fechaSolucion' => $solicitud->fechaSolucion,
                    'descripcionSolucion' => $solicitud->descripcionSolucion,
                    'descripcionRechazo' => $solicitud->descripcionRechazo,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                    'respuesta' => $solicitud->respuesta ? true : false,
                    'created_format_at' => $solicitud->created_at->format("Y-m-d h:i A"),
                    'updated_format_at' => $solicitud->updated_at->format("Y-m-d h:i A"),
                ];
            }),
        ]);
    }


    public function config() {}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::transaction(function () use (&$request) {

            $usuario = User::with('departamento')->find($request->idUser);
            $departamento = $usuario->departamento;

            $request->request->add(["idEstado" => 1]);
            $request->request->add(["folio" => $departamento->folio]);

            $solicitud = Solicitud::create($request->all());

            $departamento->folio++;
            $departamento->save();
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
        $solicitud->update($request->all());

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

    public function generarPDF($id)
    {
        $solicitud = Solicitud::with('user.departamento')->find($id);
        if (!$solicitud) {
            return response()->json(['message' => 'No se encontro la Solicitud'], 404);
        }
        // return $solicitud;

        $pdf = PDF::loadView('solicitud', ['solicitud' => $solicitud]);
        return $pdf->stream();
    }


    public function noSolucionada(string $id)
    {
        $solicitud = Solicitud::with('personalAtencion')->findOrFail($id);

        $solicitud->update(['idEstado' => 4]);

        $ids = $solicitud->personalAtencion->pluck('id');

        User::whereIn('id', $ids)->update(['disponibilidad' => true]);

        return response()->json([
            "message" => 200,
            "message_text" => "La Solicitud se asigno como no solucionada"
        ]);
    }
}
