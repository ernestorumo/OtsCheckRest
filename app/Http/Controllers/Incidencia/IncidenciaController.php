<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\ApiController;
use App\Incidencia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncidenciaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $incidencias = Incidencia::all();
        
        return $this->showAll($incidencias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $rules =[
            'observacion' => 'required',
            'tienda_id' => 'required|exists:tiendas,id',
            'tipo_id' => 'required|exists:incidencia_tipos,id'
        ];
        
        $this->validate($request,$rules);
        
        $campos = $request->all();
        
        $campos['observacion'] = $request->observacion;
        $campos['tienda_id'] = $request->tienda_id;
        $campos['tipo_id'] = $request->tipo_id;
        
        $incidencia = Incidencia::create($campos);
        
        return $this->showOne($incidencia);
    }

    /**
     * Display the specified resource.
     *
     * @param  Incidencia $incidencia
     * @return Response
     */
    public function show(Incidencia $incidencia)
    {   
        return $this->showOne($incidencia);
    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Incidencia $incidencia
     * @return Response
     */
    public function update(Request $request, Incidencia $incidencia) {        
        $rules = [
            'tienda_id' => 'exists:tiendas,id',
            'tipo_id' => 'exists:incidencia_tipos,id',
            'resolucion' => 'date',
        ];
        $this->validate($request, $rules);

        if ($request->has('observacion')) {
            $incidencia->observacion = $request->observacion;
        }
        if ($request->has('tienda_id')) {
            $incidencia->tienda_id = $request->tienda_id;
        }
        if ($request->has('tipo_id')) {
            $incidencia->tipo_id = $request->tipo_id;
        }
        if ($request->has('resolucion')) {
            $incidencia->resolucion = $request->resolucion;
        }
        if (!$incidencia->isDirty()) {
            $this->errorResponse('Se debe especificar al menos un valor diferente', 422);
        }
        $incidencia->save();
        return $this->showOne($incidencia);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Incidencia $incidencia
     * @return Response
     */
    public function destroy(Incidencia $incidencia)
    {        
        $incidencia->delete();
        
        return $this->showOne($incidencia);
    }
}
