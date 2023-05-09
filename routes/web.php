<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\AsignaturasController;
use App\Http\Controllers\AdministradoresController;
use App\Http\Controllers\EscuelasController;
use App\Http\Controllers\CSVController;



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
Route::get('/', [AuthController::class, 'verLogin'])->name('verLogin');

Route::post('/login', [AuthController::class, 'login_post'])->name('procesologin');

Route::post('/enviar', [AuthController::class, 'mail'])->name('enviar');

Route::get('/password', [AuthController::class, 'verPassword'])->name('verPassword');

//-----------------------------------------------------
//ADMIN LOGIN -----------------------------------------
//-----------------------------------------------------
Route::middleware(['auth:admin', 'revalidate'])->group(function () {
    Route::get('/admin', [AuthController::class, 'admin'])->name('admin.panel');

    //PROCESO LOGOUT
    Route::post('/logout_admin', [AuthController::class, 'logout_admin'])->name('procesologoutadmin');
});


//-----------------------------------------------------
//ALUMNO LOGIN ----------------------------------------
//-----------------------------------------------------
Route::middleware(['auth:alumno', 'revalidate'])->group(function () {
    Route::get('/alumno', [AuthController::class, 'alumno'])->name('alumno.panel');

    //PROCESO LOGOUT
    Route::post('/logout_alumno', [AuthController::class, 'logout_alumno'])->name('procesologoutalumno');

    //PROCESO CAMBIAR PASSWORD DESDE DENTRO
    Route::post('/passalumno', [AuthController::class, 'passalumno'])->name('passalumno.panel');
});

//-----------------------------------------------------
//PROFESORES LOGIN ------------------------------------
//-----------------------------------------------------

Route::middleware(['auth:profesor', 'revalidate'])->group(function () {
    Route::get('/profesor', [AuthController::class, 'profesor'])->name('profesor.panel');

    //PROCESO LOGOUT
    Route::post('/logout_profesor', [AuthController::class, 'logout_profesor'])->name('procesologoutprofesor');

    //PROCESO CAMBIAR PASSWORD DESDE DENTRO
    Route::post('/passprofe', [AuthController::class, 'passprofe'])->name('passprofe.panel');
});
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------
//-------------------------------------------------------------------------------------------------










// CRUDS

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
Route::get('cursosalumnos', [AlumnosController::class, 'cursosalumnos']);

//VER WEB FALTAS ALUMNOS 
Route::get('/faltasalu', [AlumnosController::class, 'faltasalu'])->name('faltasalu');

//VER WEB HORARIO ALUMNOS 
Route::get('/horarioalu', [AlumnosController::class, 'horarioalu'])->name('horarioalu');

//VER WEB DATOS ALUMNOS 
Route::get('/datosalu', [AlumnosController::class, 'datosalu'])->name('datosalu');

//VER WEB SCANER ALUMNOS 
Route::get('/scanalu', [AlumnosController::class, 'scanalu'])->name('scanalu');



//-----------------------------------------------------
//CURSOS ----------------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webcursos', [CursosController::class, 'webcursos'])->name('webcursos');

//MOSTRAR Y BUSCAR
Route::get('/cursos', [CursosController::class, 'indexcursos']);

Route::post('/getCurso_profe', [CursosController::class, 'cursosprofe']);

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


//ESCANER
Route::get('/escaner', [ProfesoresController::class, 'escaner'])->name('escaner');

//PASAR LISTA
Route::get('/pasarlista', [ProfesoresController::class, 'pasarlista'])->name('pasarlista');

//VER WEB FALTAS PROFESOR 
Route::get('/faltasprof', [ProfesoresController::class, 'faltasprof'])->name('faltasprof');

//VER WEB HORARIO PROFESOR 
Route::get('/cursosprof', [ProfesoresController::class, 'cursosprof'])->name('cursosprof');

//VER WEB DATOS PROFESOR 
Route::get('/datosprof', [ProfesoresController::class, 'datosprof'])->name('datosprof');


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
Route::get('cursosasignaturas', [AsignaturasController::class, 'cursosasignaturas']);

//VER PROFESORES EN ASIGNATURAS
Route::get('profesoresasignaturas', [AsignaturasController::class, 'profesoresasignaturas']);


//-----------------------------------------------------
//ADMINISTRADORES -------------------------------------
//-----------------------------------------------------

//VER WEB
Route::get('/webadministradores', [AdministradoresController::class, 'webadministradores'])->name('webadministradores');

//MOSTRAR Y BUSCAR
Route::get('/administradores', [AdministradoresController::class, 'indexadministradores']);

//INSERTAR
Route::post('/administradores', [AdministradoresController::class, 'storeadministradores']);

//ACTUALIZAR
Route::put('/administradores/{id}', [AdministradoresController::class, 'updateadministradores']);

//ELIMINAR
Route::delete('/administradores/{id}', [AdministradoresController::class, 'destroyadministradores']);

//VER PANEL DE CONTROL DEL ADMIN
Route::get('/webpanel', [AdministradoresController::class, 'webpanel'])->name('webpanel');


//CSV

//EXPORTAR ALUMNO
Route::get('/expalu', [CSVController::class, 'exp']);
// //IMPORTAR ALUMNO
Route::post('/impalu', [CSVController::class, 'imp']);
// Route::get('/expfiltroalu', [CSVController::class, 'expfiltroalu']);
// Route::get('/expfiltromat', [CSVController::class, 'expfiltromat']);
// //EXPORTAR PROFESOR
Route::get('/expprof', [CSVController::class, 'expprof']);
// //IMPORTAR PROFESOR
Route::post('/impprof', [CSVController::class, 'impprof']);