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
        'descripcionUser',
        'fechaAsignacion',
        'fechaRevision',
        'descripcionFalla',
        'fechaSolucion',
        'descripcionSolucion',
        'descripcionRechazo',
        'idTipo',
        'idEstado',
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
        return $this->hasOne(Bitacora::class);
    }

    public function respuesta()
    {
        return $this->hasOne(Respuesta::class);
    }

    public function personalAntencion()
    {
        return $this->belongsToMany(User::class, 'atencion_solicituds');
    }
}
