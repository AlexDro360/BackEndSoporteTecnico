<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Solicitud;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get("search");

        $solicitudes = Solicitud::with('user') 
            ->where("idUser", "like", "%" . $search . "%")
            ->orderBy("id", "desc")
            ->paginate(25);

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
                    'descripcionUser' => $solicitud->descripcionUser,
                    'fechaRevision' => $solicitud->fechaRevision,
                    'descripcionFalla' => $solicitud->descripcionFalla,
                    'fechaSolucion' => $solicitud->fechaSolucion,
                    'descripcionSolucion' => $solicitud->descripcionSolucion,
                    'materialRequerido' => $solicitud->materialRequerido,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
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
        $solicitud = Solicitud::create($request->all());

        return response()->json([
            "message" => 200,
            "solicitud" => [
                'idUser' => $solicitud->idUser,
                'descripcionUser' => $solicitud->descripcionUser,
                'fechaRevision' => $solicitud->fechaRevision,
                'descripcionFalla' => $solicitud->descripcionFalla,
                'fechaSolucion' => $solicitud->fechaSolucion,
                'descripcionSolucion' => $solicitud->descripcionSolucion,
                'materialRequerido' => $solicitud->materialRequerido,
                'idTipo' => $solicitud->idTipo,
                'idEstado' => $solicitud->idEstado,
            ]
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

        $solicitud->update(['status' => 0]);

        return response()->json([
            "message" => 200,
            "message_text" => "La Solicitud se Termino"
        ]);
    }
}
