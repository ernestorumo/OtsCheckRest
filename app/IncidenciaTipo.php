<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidenciaTipo extends Model
{
    protected $fillable = [
        'nombre'
    ]; 
    
    public function setNombreAttribute($valor){
        
        $this->attributes['nombre'] = strtolower($valor);
    }
    
    public function getNombreAttribute($valor){
        
        return ucwords($valor);
    }
}
