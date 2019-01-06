<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

/**
 * Tiendas
 */
Route::resource('tiendas','Tienda\TiendaController',['except' => ['create','edit','update']]);

/**
 * Incidencia
 */
Route::resource('incidencias','Incidencia\IncidenciaController',['except' => ['create','edit']]);
Route::resource('incidenciatipos','Incidencia\IncidenciaTipoController',['except' => ['create','edit']]);

/**
 * Users
 */
Route::resource('users','User\UserController',['except' => ['create','edit']]);

