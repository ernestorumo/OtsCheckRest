<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\ApiController;
use App\Tienda;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TiendaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tiendas = Tienda::all();
        
        return $this->showAll($tiendas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
          $rules = [           
            'id'=> 'required|unique:tiendas',            
        ];
        
        $this->validate($request,$rules);
        
        $campos = $request->all();
        
        $campos['id'] = $request->id;
        
        $tienda = Tienda::create($campos);
        
        return $this->showOne($tienda);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $tienda = Tienda::findOrFail($id);
        
        return $this->showOne($tienda);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $tienda = Tienda::findOrFail($id);
        
        $tienda->delete();
        
        return $this->showOne($tienda);
    }
}
