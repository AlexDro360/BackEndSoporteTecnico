<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSolicitudRequest;
use App\Models\Solicitud;
use App\Models\User;
use App\Services\PdfService;
use DB;
use Illuminate\Http\Request;
use Storage;

class SolicitudController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $estatus = $request->input('filtroEstatus', 0);
        $perPage = $request->input('perPage', 10);
        $inProcess = filter_var($request->input('inProcess', false), FILTER_VALIDATE_BOOLEAN);
        $coordination = (int) $request->input('coordination', 0);

        $solicitudes = Solicitud::with(['user.departamento', 'respuesta', 'estado', 'tipo'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {

                    $subQuery->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('surnameP', 'like', "%{$search}%")
                            ->orWhere('surnameM', 'like', "%{$search}%")
                            ->orWhereHas('departamento', function ($deptoQuery) use ($search) {
                                $deptoQuery->where('nombre', 'like', "%{$search}%")
                                    ->orWhere('abreviatura', 'like', "%{$search}%");
                            });
                    })

                        ->orWhereHas('estado', function ($estadoQuery) use ($search) {
                            $estadoQuery->where('nombre', 'like', "%{$search}%");
                        })

                        ->orWhereHas('tipo', function ($tipoQuery) use ($search) {
                            $tipoQuery->where('nombre', 'like', "%{$search}%");
                        });

                    if (str_contains($search, '/')) {
                        // Si el usuario escribió el formato completo
                        $partes = explode('/', $search);
                        $abrev = $partes[0];          // Ejemplo: "PPP"
                        $numero = (int) $partes[1];   // Transforma "001" o "01" en 1

                        $subQuery->orWhere(function ($folioQuery) use ($numero, $abrev) {
                            $folioQuery->where('folio', $numero)
                                ->whereHas('user.departamento', function ($deptoQuery) use ($abrev) {
                                    $deptoQuery->where('abreviatura', 'like', "%{$abrev}%");
                                });
                        });
                    } elseif (is_numeric($search)) {
                        // Si el usuario escribió solo números (ej. "001" o "1")
                        $numero = (int) $search;
                        $subQuery->orWhere('folio', $numero);
                    }
                });
            })
            ->when($estatus > 0, function ($query) use ($estatus) {
                $query->where('idEstado', $estatus);
            })
            ->when($inProcess, function ($query) {
                $query->whereIn('idEstado', [1, 3, 4, 5]);
            })
            // NUEVO BLOQUE: Filtro por Coordinación (Redes vs Mantenimiento)
            ->when($coordination > 0, function ($query) use ($coordination) {
                if ($coordination === 1) {
                    // Si es 1, SOLO mostramos las de tipo 2
                    $query->where('idTipo', 2);
                } elseif ($coordination === 3) {
                    // Si es 3, mostramos TODAS EXCEPTO las de tipo 2
                    $query->where('idTipo', '!=', 2);
                }
            })
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'total' => $solicitudes->total(),
            'solicitudes' => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset('storage/' . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
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
                    'respuestaData' => $solicitud->respuesta,
                    'created_format_at' => $solicitud->created_at->format('Y-m-d h:i A'),
                    'updated_format_at' => $solicitud->updated_at->format('Y-m-d h:i A'),
                ];
            }),
        ]);
    }
    public function solicitudesConcluidas(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->input('perPage', 10);

        $solicitudes = Solicitud::with(['user.departamento', 'respuesta', 'estado', 'tipo'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {

                    // A) Buscar por Departamento (nombre o abreviatura)
                    $subQuery->whereHas('user.departamento', function ($deptoQuery) use ($search) {
                        $deptoQuery->where('nombre', 'like', "%{$search}%")
                            ->orWhere('abreviatura', 'like', "%{$search}%");
                    });

                    // B) Interceptar y decodificar el Folio ("PPP/001" o "001")
                    if (str_contains($search, '/')) {
                        // Si escribe el formato completo (Ej. "PPP/001")
                        $partes = explode('/', $search);
                        $abrev = $partes[0];
                        $numero = (int) $partes[1];

                        $subQuery->orWhere(function ($folioQuery) use ($numero, $abrev) {
                            $folioQuery->where('folio', $numero)
                                ->whereHas('user.departamento', function ($deptoQuery) use ($abrev) {
                                    $deptoQuery->where('abreviatura', 'like', "%{$abrev}%");
                                });
                        });
                    } elseif (is_numeric($search)) {
                        // Si escribe solo números (Ej. "001" o "1")
                        $numero = (int) $search;
                        $subQuery->orWhere('folio', $numero);
                    }
                });
            })
            ->whereIn('idEstado', [7, 8])
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'total' => $solicitudes->total(),
            'solicitudes' => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset('storage/' . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
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
                    'respuestaData' => $solicitud->respuesta,
                    'created_format_at' => $solicitud->created_at->format('Y-m-d h:i A'),
                    'updated_format_at' => $solicitud->updated_at->format('Y-m-d h:i A'),
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

        $solicitudes = Solicitud::with(['user.departamento', 'respuesta', 'estado', 'tipo'])
            ->where('idUser', $id)
            ->when($search, function ($query) use ($search) {

                // AGRUPACIÓN CRÍTICA: Todo el buscador va entre paréntesis
                // SQL resultante: WHERE idUser = ? AND (estado LIKE ? OR tipo LIKE ? OR folio = ?)
                $query->where(function ($subQuery) use ($search) {

                    // A) Buscar por nombre del Estado
                    $subQuery->whereHas('estado', function ($estadoQuery) use ($search) {
                        $estadoQuery->where('nombre', 'like', "%{$search}%");
                    })

                        // B) Buscar por nombre del Tipo de problema
                        ->orWhereHas('tipo', function ($tipoQuery) use ($search) {
                            $tipoQuery->where('nombre', 'like', "%{$search}%");
                        })

                        // C) Buscar por Departamento (nombre o abreviatura)
                        ->orWhereHas('user.departamento', function ($deptoQuery) use ($search) {
                            $deptoQuery->where('nombre', 'like', "%{$search}%")
                                ->orWhere('abreviatura', 'like', "%{$search}%");
                        });

                    // D) MAGIA: Interceptar y decodificar el Folio ("PPP/001" o "001")
                    if (str_contains($search, '/')) {
                        $partes = explode('/', $search);
                        $abrev = $partes[0];
                        $numero = (int) $partes[1];

                        $subQuery->orWhere(function ($folioQuery) use ($numero, $abrev) {
                            $folioQuery->where('folio', $numero)
                                ->whereHas('user.departamento', function ($deptoQuery) use ($abrev) {
                                    $deptoQuery->where('abreviatura', 'like', "%{$abrev}%");
                                });
                        });
                    } elseif (is_numeric($search)) {
                        $numero = (int) $search;
                        $subQuery->orWhere('folio', $numero);
                    }
                });
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'total' => $solicitudes->total(),
            'solicitudes' => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset('storage/' . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
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
                    'created_format_at' => $solicitud->created_at->format('Y-m-d h:i A'),
                    'updated_format_at' => $solicitud->updated_at->format('Y-m-d h:i A'),
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
        $inProcess = filter_var($request->input('inProcess', false), FILTER_VALIDATE_BOOLEAN);


        $solicitudes = Solicitud::with(['personalAtencion', 'user.departamento', 'respuesta', 'estado', 'tipo'])
            ->whereHas('personalAtencion', function ($query) use ($id) {
                $query->where('user_id', $id)
                    ->where('atencion_solicituds.estado', 1);
            })
            // ->whereHas('personalAtencion', function ($q) use ($id) {
            //     $q->where('user_id', $id);
            // })
            ->when($search, function ($query) use ($search) {

                // AGRUPACIÓN CRÍTICA: Todo el buscador va entre paréntesis
                // SQL: WHERE personalAtencion = ID AND (usuario LIKE x OR folio = y OR ...)
                $query->where(function ($subQuery) use ($search) {

                    // A) Buscar por datos del Solicitante (Usuario) y su Departamento
                    $subQuery->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('surnameP', 'like', "%{$search}%")
                            ->orWhere('surnameM', 'like', "%{$search}%")
                            ->orWhereHas('departamento', function ($deptoQuery) use ($search) {
                                $deptoQuery->where('nombre', 'like', "%{$search}%")
                                    ->orWhere('abreviatura', 'like', "%{$search}%");
                            });
                    })

                        // B) Buscar por nombre del Estado
                        ->orWhereHas('estado', function ($estadoQuery) use ($search) {
                            $estadoQuery->where('nombre', 'like', "%{$search}%");
                        })

                        // C) Buscar por nombre del Tipo de problema
                        ->orWhereHas('tipo', function ($tipoQuery) use ($search) {
                            $tipoQuery->where('nombre', 'like', "%{$search}%");
                        });

                    // D) MAGIA: Interceptar y decodificar el Folio ("PPP/001" o "001")
                    if (str_contains($search, '/')) {
                        $partes = explode('/', $search);
                        $abrev = $partes[0];
                        $numero = (int) $partes[1];

                        $subQuery->orWhere(function ($folioQuery) use ($numero, $abrev) {
                            $folioQuery->where('folio', $numero)
                                ->whereHas('user.departamento', function ($deptoQuery) use ($abrev) {
                                    $deptoQuery->where('abreviatura', 'like', "%{$abrev}%");
                                });
                        });
                    } elseif (is_numeric($search)) {
                        $numero = (int) $search;
                        $subQuery->orWhere('folio', $numero);
                    }
                });
            })
            ->when($inProcess, function ($query) {
                $query->whereIn('idEstado', [1, 3, 4, 5]);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return response()->json([
            'total' => $solicitudes->total(),
            'solicitudes' => $solicitudes->map(function ($solicitud) {
                return [
                    'user' => $solicitud->user ? [
                        'id' => $solicitud->user->id,
                        'full_name' => $solicitud->user->name . ' ' . $solicitud->user->surnameP . ' ' . $solicitud->user->surnameM,
                        'email' => $solicitud->user->email,
                        'phone' => $solicitud->user->phone,
                        'departamento' => $solicitud->user->departamento ? $solicitud->user->departamento->nombre : 'Sin departamento',
                        'departamentoC' => $solicitud->user->departamento,
                        'num_empleado' => $solicitud->user->num_empleado,
                        'avatar' => $solicitud->user->avatar ? asset('storage/' . $solicitud->user->avatar) : 'https://static.vecteezy.com/system/resources/previews/000/439/863/original/vector-users-icon.jpg',
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
                    'created_format_at' => $solicitud->created_at->format('Y-m-d h:i A'),
                    'updated_format_at' => $solicitud->updated_at->format('Y-m-d h:i A'),
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

            $urlPdf = $this->pdfService->generarPdf('solicitud', ['data' => $solicitud], 'solicitud', 'pdfsSolicitudes');

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
        if (! $solicitud) {
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

            $urlPdf = $this->pdfService->generarPdf('solicitud', ['data' => $solicitud], 'solicitud', 'pdfsSolicitudes');
            $solicitud->path_pdf = $urlPdf;

            $solicitud->save();

            return response()->json([
                'message' => 200,
                'user' => [
                    'id' => $solicitud->id,
                    'descripcion' => $solicitud->descripcion,
                    'idBitacora' => $solicitud->idBitacora,
                    'idUser' => $solicitud->idUser,
                    'idTipo' => $solicitud->idTipo,
                    'idEstado' => $solicitud->idEstado,
                ],
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
            'message' => 200,
            'message_text' => 'La Solicitud se Terminó',
        ]);
    }

    public function rechazar(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        $solicitud->update(['idEstado' => 2]);

        return response()->json([
            'message' => 200,
            'message_text' => 'La Solicitud se Rechazó',
        ]);
    }

    public function obtenerPDF($id)
    {
        $solicitud = Solicitud::find($id);

        if (! $solicitud || ! Storage::disk('pdfsSolicitudes')->exists($solicitud->path_pdf)) {
            return response()->json(['error' => 'Archivo no encontrado'], 404);
        }

        return response()->file(
            Storage::disk('pdfsSolicitudes')->path($solicitud->path_pdf),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="Solicitud_' . $solicitud->id . '.pdf"',
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
            'message' => 200,
            'message_text' => 'La solicitud se asignó como no solucionada',
        ]);
    }

    public function confirmarSolucion(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        // if ($solicitud->idUser !== auth()->id()) {
        //     return response()->json([
        //         'message' => 'No tienes permiso para confirmar esta solicitud. Solo el usuario que la creó puede validarla.',
        //     ], 403); 
        // }

        if ($solicitud->idEstado != 6) {
            return response()->json([
                'message' => 'La solicitud debe estar finalizada por el Centro de Cómputo antes de poder confirmar el trabajo realizado.',
            ], 400);
        }
        $solicitud->update([
            'idEstado' => 7,
            'fecha_confirmacion' => now()
        ]);

        return response()->json([
            'message' => 'Solución confirmada y solicitud cerrada exitosamente.',
        ], 200);
    }

    public function archivarSolicitud(string $id)
    {
        $solicitud = Solicitud::findOrFail($id);

        if ($solicitud->idEstado != 7) {
            return response()->json([
                'message' => 'La solicitud debe estar confirmada por el Jefe de Departamento quien creo la solicitud antes de poder ser archivada.',
            ], 400);
        }
        $solicitud->update([
            'idEstado' => 8,
            'fecha_archivado' => now()
        ]);

        return response()->json([
            'message' => 'Solicitud archivada exitosamente.',
        ], 200);
    }
}
