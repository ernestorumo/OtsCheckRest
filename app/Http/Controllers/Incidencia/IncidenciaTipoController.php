<?php

namespace App\Http\Controllers\Incidencia;

use App\Http\Controllers\ApiController;
use App\IncidenciaTipo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IncidenciaTipoController extends ApiController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $incidenciatipos = IncidenciaTipo::all();

        return $this->showAll($incidenciatipos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request) {
        $rules = [
            'nombre' => 'required|unique:incidencia_tipos',
        ];

        $this->validate($request, $rules);

        $campos = $request->all();

        $campos['nombre'] = $request->nombre;

        $incidenciatipo = IncidenciaTipo::create($campos);

        return $this->showOne($incidenciatipo);
    }

    /**
     * Display the specified resource.
     *
     * @param  IncidenciaTipo $incidenciatipo
     * @return Response
     */
    public function show(IncidenciaTipo $incidenciatipo) 
    {       
        return $this->showOne($incidenciatipo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  IncidenciaTipo $incidenciatipo
     * @return Response
     */
    public function update(Request $request, IncidenciaTipo $incidenciatipo) {
        
        $rules = [
            'nombre' => 'required|unique:incidencia_tipos',
        ];

        $this->validate($request, $rules);

        if ($request->has('nombre')) {
            $incidenciatipo->nombre = $request->nombre;
        }

        if (!$incidenciatipo->isDirty()) {
            $this->errorResponse('Se debe especificar al menos un valor diferente', 422);
        }
        $incidenciatipo->save();

        return $this->showOne($incidenciatipo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  IncidenciaTipo $incidenciatipo
     * @return Response
     */
    public function destroy(IncidenciaTipo $incidenciatipo) 
    {        
        $incidenciatipo->delete();

        return $this->showOne($incidenciatipo);
    }

}
