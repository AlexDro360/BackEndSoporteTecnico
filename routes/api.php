<?php

use App\Http\Controllers\AtencionSolicitudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\CentroComputoJefeController;
use App\Http\Controllers\ConfigAdicionalesController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\TipoMantenimientoController;
use App\Http\Controllers\TipoServicioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'prefix' => 'auth',
    //'middleware' => ['auth:api'], //,'permission:publish articles|edit articles'

], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
});

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::resource("roles", RolePermissionController::class);
    Route::post('/users/{id}', [UserAccessController::class, 'update']);
    Route::get("users/config", [UserAccessController::class, 'config']);
    Route::get('/users/alta/{id}', [UserAccessController::class, 'alta']);
    Route::resource("users", UserAccessController::class);

    Route::post('/solicitudes/{id}', [UserAccessController::class, 'update']);
});

Route::group([
    'prefix' => 'bitacora',
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('/', [BitacoraController::class, 'index']);
    Route::get('/{id}', [BitacoraController::class, 'show']);
    Route::post('/agregar', [BitacoraController::class, 'store']);
    Route::put('/editar/{id}', [BitacoraController::class, 'update']);
    Route::delete('/borrar/{id}', [BitacoraController::class, 'destroy']);
    Route::get('/buscar/{id}', [BitacoraController::class, 'getBitacora']);
});

Route::group([
    'prefix' => 'respuesta',
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('/', [RespuestaController::class, 'index']);
    Route::get('/{id}', [RespuestaController::class, 'show']);
    Route::post('/agregar', [RespuestaController::class, 'store']);
    Route::put('/editar/{id}', [RespuestaController::class, 'update']);
    Route::delete('/borrar/{id}', [RespuestaController::class, 'destroy']);
    Route::get('/buscar/{id}', [RespuestaController::class, 'getRespuesta']);
});


Route::group([
    'prefix' => 'atencion_solicitud',
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('tecnicos/', [AtencionSolicitudController::class, 'tecnicos']);
    Route::get('tecnicos/{id}', [AtencionSolicitudController::class, 'tecnicosSolicitud']);
    Route::post('/asignar/{id}', [AtencionSolicitudController::class, 'asignarTecnicos']);
    Route::put('/editar/{id}', [AtencionSolicitudController::class, 'update']);
    Route::delete('/borrar/{id}', [AtencionSolicitudController::class, 'destroy']);
});

Route::group([
    'prefix' => 'jefe_cc',
    'middleware' => 'auth:api',
], function ($router) {
    Route::apiResource('jefes', CentroComputoJefeController::class);
    Route::get('jefe-activo/', [CentroComputoJefeController::class, 'jefeActivo']);
});

Route::group([
    'prefix' => 'config-adicionales',
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('/folios', [ConfigAdicionalesController::class, 'show']);
    Route::post('/folios/reiniciar/{id}', [ConfigAdicionalesController::class, 'resetFolioSolicitud']);
    Route::put('/folios/reset/respuesta', [ConfigAdicionalesController::class, 'resetFolioRespuesta']);
    Route::put('/folios/update/respuesta', [ConfigAdicionalesController::class, 'updateFolioRespuesta']);
    Route::get('/folios/respuesta', [ConfigAdicionalesController::class, 'getFolioRespuesta']);
    Route::get('/config-adicionales/folios/respuesta', [ConfigAdicionalesController::class, 'getFolioRespuesta']);
    Route::put('/folios/actualizar/{id}', [ConfigAdicionalesController::class, 'updateFolios']);
    Route::get('/estatus', [ConfigAdicionalesController::class, 'getEstatus']);
    Route::get('/folios/{id}', [ConfigAdicionalesController::class, 'showMyFolio']);
});

Route::group([
    'prefix' => 'reporte',
    // 'middleware' => 'auth:api',
], function ($router) {
    Route::get('/datos-graficas', [ReportesController::class, 'getDatos']);
    Route::get('/filtro', [ReportesController::class, 'filtro']);
});

Route::resource("solicitudes", SolicitudController::class);
Route::patch('/solicitud/rechazar/{id}', [SolicitudController::class, 'rechazar']);
Route::get('/solicitud/mis-solicitudes/{id}', [SolicitudController::class, 'misSolicitudes']);
Route::get('/solicitud/mis-solicitudes-atendidas/{id}', [SolicitudController::class, 'misSolicitudesAtendidas']);
Route::put('/solicitud/nosolucion/{id}', [SolicitudController::class, 'noSolucionada']);

Route::resource("estados", EstadoController::class);
Route::resource("tipos", TipoController::class);
Route::get('tipomantenimientos', [TipoMantenimientoController::class, 'index']);
Route::get('tiposervicios', [TipoServicioController::class, 'index']);
Route::get('departamentos', 'App\Http\Controllers\DepartamentoController@index');

Route::get('pdf/respuesta/{id}', [RespuestaController::class, 'obtenerPDF']);
Route::get('pdf/solicitud/{id}', [SolicitudController::class, 'obtenerPDF']);
