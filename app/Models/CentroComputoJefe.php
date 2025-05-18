<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CentroComputoJefe extends Model
{
    use HasFactory;

    protected $table = 'centro_computo_jefes';

    protected $fillable = [
        'nombres',
        'apellidoP',
        'apellidoM',
        'estado',
    ];

    protected $appends = ['nombreCompleto'];


    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'idCentroComputoJefe');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidoP} {$this->apellidoM}";
    }
}
