<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\AsignaturasController;

use App\Http\Controllers\AuthController;


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


//-----------------------------------------------------
//PROCESAR LOGIN Y CAMBIAR PASSWORD -------------------
//-----------------------------------------------------
Route::get('/', [AuthController::class, 'verLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login_post'])->name('login.post');

Route::post('/enviar', [AuthController::class, 'mail'])->name('enviar');


//-----------------------------------------------------
//ADMIN LOGIN -----------------------------------------
//-----------------------------------------------------
Route::middleware(['auth:admin', 'revalidate'])->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin.panel');

    //PROCESO LOGOUT
    Route::post('/logout_admin', [AuthController::class, 'logout_admin'])->name('logout.admin');
});


//-----------------------------------------------------
//ALUMNO LOGIN ----------------------------------------
//-----------------------------------------------------
Route::middleware(['auth:alumno', 'revalidate'])->group(function () {
    Route::get('/alumno', [AuthController::class, 'alumno'])->name('alumno.panel');

    //PROCESO LOGOUT
    Route::post('/logout_alumno', [AuthController::class, 'logout_alumno'])->name('logout.alumno');

    //PROCESO CAMBIAR PASSWORD DESDE DENTRO
    Route::post('/passalumno', [AuthController::class, 'passalumno'])->name('passalumno.panel');
});

//-----------------------------------------------------
//PROFESORES LOGIN ------------------------------------
//-----------------------------------------------------


Route::middleware(['auth:profesor', 'revalidate'])->group(function () {
    Route::get('/profesores', [AuthController::class, 'profesor'])->name('profesor.panel');

    //PROCESO LOGOUT
    Route::post('/logout_profesor', [AuthController::class, 'logout_profesor'])->name('logout.profesor');

    //PROCESO CAMBIAR PASSWORD DESDE DENTRO
    Route::post('/passprofe', [AuthController::class, 'passprofe'])->name('passprofe.panel');
});


//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
































// MARC
// NO TOCAR
// //-----------------------------------------------------
// //LOGIN -----------------------------------------------
// //-----------------------------------------------------

// //VER LOGIN
// Route::get('/login', function () {
//     return view('login');
// });

// // //VER PASSWORD
Route::get('/password', function () {
    return view('password');
});

// //VER LAYOUT
// Route::get('/layoutalumno', function () {
//     return view('layouts/layoutalumno');
// });

// //VER LAYOUT
// Route::get('/layoutadmin', function () {
//     return view('layouts/layoutadmin');
// });

// //VER LAYOUT
// Route::get('/layoutprofesor', function () {
//     return view('layouts/layoutprofesor');
// });

// //VER ADMIN
// Route::get('/admin', function () {
//     return view('admin');
// });

// //VER PROFESOR
// Route::get('/profesor', function () {
//     return view('profesor');
// });

// //VER ALUMNO
// Route::get('/alumno', function () {
//     return view('alumno');
// });

// //VER ALUMNO
// Route::get('/principal', function () {
//     return view('principal');
// });







// //-----------------------------------------------------
// //ALUMNOS ---------------------------------------------
// //-----------------------------------------------------

// //VER WEB
// Route::get('/webalumnos', [AlumnosController::class, 'webalumnos'])->name('webalumnos');

// //MOSTRAR Y BUSCAR
// Route::get('/alumnos', [AlumnosController::class, 'indexalumnos']);

// //INSERTAR
// Route::post('/alumnos', [AlumnosController::class, 'storealumnos']);

// //ACTUALIZAR
// Route::put('/alumnos/{id}', [AlumnosController::class, 'updatealumnos']);

// //ELIMINAR
// Route::delete('/alumnos/{id}', [AlumnosController::class, 'destroyalumnos']);

// //VER CURSOS EN ALUMNOS
// Route::get('cursos', [AlumnosController::class, 'cursos']);




// //-----------------------------------------------------
// //CURSOS ----------------------------------------------
// //-----------------------------------------------------

// //VER WEB
// Route::get('/webcursos', [CursosController::class, 'webcursos'])->name('webcursos');

// //MOSTRAR Y BUSCAR
// Route::get('/cursos', [CursosController::class, 'indexcursos']);

// //INSERTAR
// Route::post('/cursos', [CursosController::class, 'storecursos']);

// //ACTUALIZAR
// Route::put('/cursos/{id}', [CursosController::class, 'updatecursos']);

// //ELIMINAR
// Route::delete('/cursos/{id}', [CursosController::class, 'destroycursos']);

// //VER ESCUELAS EN CURSOS
// Route::get('escuelas', [CursosController::class, 'escuelas']);



// //-----------------------------------------------------
// //PROFESORES ------------------------------------------
// //-----------------------------------------------------

// //VER WEB
// Route::get('/webprofesores', [ProfesoresController::class, 'webprofesores'])->name('webprofesores');

// //MOSTRAR Y BUSCAR
// Route::get('/profesores', [ProfesoresController::class, 'indexprofesores']);

// //INSERTAR
// Route::post('/profesores', [ProfesoresController::class, 'storeprofesores']);

// //ACTUALIZAR
// Route::put('/profesores/{id}', [ProfesoresController::class, 'updateprofesores']);

// //ELIMINAR
// Route::delete('/profesores/{id}', [ProfesoresController::class, 'destroyprofesores']);


// //-----------------------------------------------------
// //ASIGNATURAS -----------------------------------------
// //-----------------------------------------------------

// //VER WEB
// Route::get('/webasignaturas', [AsignaturasController::class, 'webasignaturas'])->name('webasignaturas');

// //MOSTRAR Y BUSCAR
// Route::get('/asignaturas', [AsignaturasController::class, 'indexasignaturas']);

// //INSERTAR
// Route::post('/asignaturas', [AsignaturasController::class, 'storeasignaturas']);

// //ACTUALIZAR
// Route::put('/asignaturas/{id}', [AsignaturasController::class, 'updateasignaturas']);

// //ELIMINAR
// Route::delete('/asignaturas/{id}', [AsignaturasController::class, 'destroyasignaturas']);

// //VER CURSOS EN ASIGNATURAS
// Route::get('cursos', [AsignaturasController::class, 'cursos']);

// //VER PROFESORES EN ASIGNATURAS
// Route::get('profesores', [AsignaturasController::class, 'profesores']);
