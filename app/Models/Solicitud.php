<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Solicitud extends Model
{
    use HasFactory;

    protected $fillable = [
        'idUser',
        'folio',
        'descripcionUser',
        'idTipo',
        'idEstado',
        'path_pdf',
        'fecha_confirmacion',
        'fecha_archivado',
    ];

    protected $casts = [
        'fecha_confirmacion' => 'datetime',
        'fecha_archivado' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'idEstado');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'idTipo');
    }



    public function bitacora()
    {
        return $this->hasOne(Bitacora::class, 'idSolicitud');
    }

    public function respuesta()
    {
        return $this->hasOne(Respuesta::class, 'idSolicitud');
    }

    public function personalAtencion()
    {
        return $this->belongsToMany(User::class, 'atencion_solicituds')
            ->withPivot('estado')
            ->withTimestamps();;
    }
}
