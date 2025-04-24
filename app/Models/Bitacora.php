<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'descFalla',
        'descSolucion',
        'materialReq',
        'idSolicitud',
    ];

    public function solicitud(){
        return $this->belongsTo(Solicitud::class, 'idSolicitud');
    }
}
