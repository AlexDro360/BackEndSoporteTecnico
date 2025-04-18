<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $fillable = [
        'asunto',
        'descripcion',
        'fecha',
        'nombreAprovo',
        'idTipoMantenimiento',
        'idTipoServicio',
        'idSolicitud',
    ];

    public function tipoServicio(){
        return $this->belongsTo(TipoServicio::class);
    }
    
    public function tipoMantenimiento()
    {
        return $this->belongsTo(TipoMantenimiento::class);
    }

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class);
    }
}
