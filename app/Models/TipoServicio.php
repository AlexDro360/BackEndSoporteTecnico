<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'idTipoServicio');
    }
}
