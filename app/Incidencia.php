<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    protected $fillable = [
        'tienda_id',
        'tipo_id',
        'observacion',
        'resolucion'
    ];
}
