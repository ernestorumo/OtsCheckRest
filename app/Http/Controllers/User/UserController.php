<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\User;
use Illuminate\Http\Request;

class UserController //extends ApiController
{
    use \App\Traits\ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return Collection User
     */
    public function index()
    {
        $users = User::all();
        
        //return response()->json($users, 200);
        
        $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return User
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6|confirmed'
        ];
        
        $this->validate($request,$rules);
        
        $campos = $request->all();
        
        $campos['nombre'] = $request->nombre;
        $campos['password'] = bcrypt($request->password);
        $campos['email'] = $request->email;
        
        $user = User::create($campos);
        
        $this->showOne($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return User
     */
    public function show(User $user)
    {
        $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User $user
     * @return User
     */
    public function update(Request $request, User $user)
    {        
        $rules = [
            //Solo valida el email exceptuando el del usuario actual
            'email' =>'email|unique:users,email,'. $user->id,
            'password'=> 'min:6|confirmed'
        ];
        
        $this->validate($request, $rules);
       
        if($request->has('name')){
           $user->name = $request->name;
        }
        
        if($request->has('email') && $user->email != $request->email){
            $user->email = $request->email;
        }
        
        if($request->has('password')){
            $user->password = bcrypt($request->password);
        }
        
        if(!$user->isDirty()){
            $this->errorResponse('Se debe especificar al menos un valor diferente',422);
        }
        $user->save();
        
        $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {                
        $user->delete();
        
        $this->showOne($user);
    }
}
