<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\AsignaturasController;

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
//LOGIN -----------------------------------------------
//-----------------------------------------------------

//VER LOGIN
Route::get('/login', function () {
    return view('login');
});

//VER PASSWORD
Route::get('/password', function () {
    return view('password');
});

//VER LAYOUT
Route::get('/layoutalumno', function () {
    return view('layouts/layoutalumno');
});

//VER LAYOUT
Route::get('/layoutadmin', function () {
    return view('layouts/layoutadmin');
});

//VER LAYOUT
Route::get('/layoutprofesor', function () {
    return view('layouts/layoutprofesor');
});

//VER ADMIN
Route::get('/admin', function () {
    return view('admin');
});

//VER PROFESOR
Route::get('/profesor', function () {
    return view('profesor');
});

//VER ALUMNO
Route::get('/alumno', function () {
    return view('alumno');
});






//-----------------------------------------------------
//ALUMNOS ---------------------------------------------
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




//-----------------------------------------------------
//CURSOS ----------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webcursos', [CursosController::class, 'webcursos'])->name('webcursos');

//MOSTRAR Y BUSCAR
Route::get('/cursos', [CursosController::class, 'indexcursos']);

//INSERTAR
Route::post('/cursos', [CursosController::class, 'storecursos']);

//ACTUALIZAR
Route::put('/cursos/{id}', [CursosController::class, 'updatecursos']);

//ELIMINAR
Route::delete('/cursos/{id}', [CursosController::class, 'destroycursos']);

//VER ESCUELAS EN CURSOS
Route::get('escuelas', [CursosController::class, 'escuelas']);



//-----------------------------------------------------
//PROFESORES ------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webprofesores', [ProfesoresController::class, 'webprofesores'])->name('webprofesores');

//MOSTRAR Y BUSCAR
Route::get('/profesores', [ProfesoresController::class, 'indexprofesores']);

//INSERTAR
Route::post('/profesores', [ProfesoresController::class, 'storeprofesores']);

//ACTUALIZAR
Route::put('/profesores/{id}', [ProfesoresController::class, 'updateprofesores']);

//ELIMINAR
Route::delete('/profesores/{id}', [ProfesoresController::class, 'destroyprofesores']);


//-----------------------------------------------------
//ASIGNATURAS -----------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webasignaturas', [AsignaturasController::class, 'webasignaturas'])->name('webasignaturas');

//MOSTRAR Y BUSCAR
Route::get('/asignaturas', [AsignaturasController::class, 'indexasignaturas']);

//INSERTAR
Route::post('/asignaturas', [AsignaturasController::class, 'storeasignaturas']);

//ACTUALIZAR
Route::put('/asignaturas/{id}', [AsignaturasController::class, 'updateasignaturas']);

//ELIMINAR
Route::delete('/asignaturas/{id}', [AsignaturasController::class, 'destroyasignaturas']);

//VER CURSOS EN ASIGNATURAS
Route::get('cursos', [AsignaturasController::class, 'cursos']);

//VER PROFESORES EN ASIGNATURAS
Route::get('profesores', [AsignaturasController::class, 'profesores']);
