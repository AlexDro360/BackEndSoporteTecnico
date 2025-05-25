<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Solicitud;
use App\Models\Tipo;
use DB;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function getDatos(Request $request)
    {
        $idDepartamento = $request->query('idDepartamento');
        $idTipo = $request->query('idTipo');
        $fechaInicio = $request->query('fechaInicio');
        $fechaFin = $request->query('fechaFin');

        // para las cards
        $baseQuery = Solicitud::query()
            ->leftJoin('users', 'solicituds.idUser', '=', 'users.id')
            ->when($idTipo && $idTipo !== 'null', function ($query) use ($idTipo) {
                return $query->where('solicituds.idTipo', $idTipo);
            })
            ->when($idDepartamento && $idDepartamento !== 'null', function ($query) use ($idDepartamento) {
                return $query->where('users.departamento_id', $idDepartamento);
            })
            ->when($fechaInicio && $fechaFin && $fechaInicio !== 'null' && $fechaFin !== 'null', function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('solicituds.created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ]);
            });

        $totalSolicitudes = (clone $baseQuery)->count();

        $solicitudesRechazadas = (clone $baseQuery)
            ->where('solicituds.idEstado', 2)
            ->count();

        $solicitudesFinalizadas = (clone $baseQuery)
            ->where('solicituds.idEstado', 5)
            ->count();

        $solicitudesProceso = (clone $baseQuery)
            ->whereIn('solicituds.idEstado', [3, 4])
            ->count();


        //para la grafica de departamentos
        $datos = DB::table('departamentos')
            ->leftJoin('users', 'users.departamento_id', '=', 'departamentos.id')
            ->leftJoin('solicituds', 'solicituds.idUser', '=', 'users.id')
            ->when($idTipo && $idTipo !== 'null', function ($query) use ($idTipo) {
                return $query->where('solicituds.idTipo', $idTipo);
            })
            ->when($idDepartamento && $idDepartamento !== 'null', function ($query) use ($idDepartamento) {
                return $query->where('users.departamento_id', $idDepartamento);
            })
            ->when($fechaInicio && $fechaFin && $fechaFin !== 'null' && $fechaInicio !== 'null', function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('solicituds.created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ]);
            })
            ->select('departamentos.abreviatura as departamento', DB::raw('COUNT(solicituds.id) as totalSolicitudes'))
            ->groupBy('departamentos.abreviatura')
            ->orderByDesc('totalSolicitudes')
            ->get();


        //para la grafica por tipos
        $datosTipo = DB::table('tipos')
            ->leftJoin('solicituds', 'solicituds.idTipo', '=', 'tipos.id')
            ->leftJoin('users', 'solicituds.idUser', '=', 'users.id')
            ->when($idTipo && $idTipo !== 'null', function ($query) use ($idTipo) {
                return $query->where('solicituds.idTipo', $idTipo);
            })
            ->when($idDepartamento && $idDepartamento !== 'null', function ($query) use ($idDepartamento) {
                return $query->where('users.departamento_id', $idDepartamento);
            })
            ->when($fechaInicio && $fechaFin && $fechaFin !== 'null' && $fechaInicio !== 'null', function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('solicituds.created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ]);
            })
            ->select('tipos.nombre as tipoSoli', DB::raw('COUNT(solicituds.id) as totalSolicitudes'))
            ->groupBy('tipos.nombre')
            ->orderByDesc('totalSolicitudes')
            ->get();

        $departamentos = $datos->pluck('departamento')->toArray();
        $cantidadesDep = $datos->pluck('totalSolicitudes')->toArray();

        $tiposSoli = $datosTipo->pluck('tipoSoli')->toArray();
        $cantidadesTip = $datosTipo->pluck('totalSolicitudes')->toArray();


        $porDiaSemana = DB::table('solicituds')
            ->selectRaw("DAYNAME(created_at) as dia, DAYOFWEEK(created_at) as dia_num, COUNT(*) as total")
            ->groupByRaw("DAYNAME(created_at), DAYOFWEEK(created_at)")
            ->orderByRaw("DAYOFWEEK(created_at)")
            ->get();

        $cantDia = $porDiaSemana->pluck('total')->toArray();
        $dia = $porDiaSemana->pluck('dia')->toArray();



        $porHora = DB::table('solicituds')
            ->selectRaw("HOUR(created_at) as hora, COUNT(*) as total")
            ->groupByRaw("HOUR(created_at)")
            ->orderByRaw("HOUR(created_at)")
            ->get();
        $cantHora = $porHora->pluck('total')->toArray();
        $hora = $porHora->pluck('hora')->toArray();


        $porMes = DB::table('solicituds')
            ->selectRaw("MONTHNAME(created_at) as mes, COUNT(*) as total, MONTH(created_at) as mes_num")
            ->groupByRaw("MONTHNAME(created_at), MONTH(created_at)")
            ->orderByRaw("mes_num")
            ->get();


        $cantMes = $porMes->pluck('total')->toArray();
        $mes = $porMes->pluck('mes')->toArray();

        $datosPorFecha = DB::table('solicituds')
            ->leftJoin('users', 'solicituds.idUser', '=', 'users.id')
            ->when($idTipo && $idTipo !== 'null', function ($query) use ($idTipo) {
                return $query->where('solicituds.idTipo', $idTipo);
            })
            ->when($idDepartamento && $idDepartamento !== 'null', function ($query) use ($idDepartamento) {
                return $query->where('users.departamento_id', $idDepartamento);
            })
            ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                return $query->whereBetween('solicituds.created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ]);
            })
            ->selectRaw("DATE(solicituds.created_at) as x, COUNT(*) as y")
            ->groupByRaw("DATE(solicituds.created_at)")
            ->orderByRaw("DATE(solicituds.created_at)")
            ->get()
            ->map(function ($item) {
                return [
                    'x' => $item->x,
                    'y' => $item->y
                ];
            })
            ->toArray();



        $respuesta = [
            'cantidades' => [
                'totalSolicitudes' => $totalSolicitudes,
                'soliRechazadas' => $solicitudesRechazadas,
                'soliFinalizadas' => $solicitudesFinalizadas,
                'soliProceso' => $solicitudesProceso,
            ],
            'barrasCantSoli' => [
                'cantidadSolicitudes' => $cantidadesDep,
                'departamento' => $departamentos
            ],
            'grafTipoSoli' => [
                'cantidadSolicitudes' => $cantidadesTip,
                'tiposSolicitudes' => $tiposSoli,
            ],
            'hora' => [
                'hora' => $hora,
                'total' => $cantHora
            ],
            'mes' => [
                'mes' => $mes,
                'total' => $cantMes
            ],
            'dia' => [
                'dia' => $dia,
                'total' => $cantDia
            ],
            'fecha' => $datosPorFecha

        ];

        return response()->json($respuesta);
    }

    public function filtro()
    {
        $departamentosFil = Departamento::all();
        $tiposSoliFil = Tipo::all();
        $respuesta = [
            'departamentos' => $departamentosFil,
            'tiposSoli' => $tiposSoliFil,
        ];
        return response()->json($respuesta);
    }
}
