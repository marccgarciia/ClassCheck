<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('principal');
});

//-----------------------------------------------------
//ALUMNOS ------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webalumnos', [AlumnosController::class, 'webalumnos'])->name('webalumnos');

//MOSTRAR Y BUSCAR
Route::get('/alumnos', [AlumnosController::class, 'indexalumnos']);

//INSERTAR
Route::post('/alumnos', [AlumnosController::class, 'storealumnos']);

//ACTUALIZAR
Route::put('/alumnos/{id}', [AlumnosController::class, 'updatealumnos']);

//ELIMINAR
Route::delete('/alumnos/{id}', [AlumnosController::class, 'destroyalumnos']);

//VER CURSOS EN ALUMNOS
Route::get('cursos', [AlumnosController::class, 'cursos']);
