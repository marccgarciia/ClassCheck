<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'login_post' ])->name('login.post');

Route::middleware(['auth:admin', 'revalidate'])->group(function () {
    Route::get('/adminpanel', [AuthController::class, 'admin'])->name('admin.panel');
    Route::post('/logout_admin', [AuthController::class, 'logout_admin'])->name('logout.admin');
});

Route::middleware(['auth:alumno', 'revalidate'])->group(function () {
    Route::get('/alumnopanel', [AuthController::class, 'alumno'])->name('alumno.panel');
    Route::post('/logout_alumno', [AuthController::class, 'logout_alumno'])->name('logout.alumno');
});

Route::middleware(['auth:profesore', 'revalidate'])->group(function () {
    Route::get('/profesorepanel', [AuthController::class, 'profesore'])->name('profesore.panel');
    Route::post('/logout_profesore', [AuthController::class, 'logout_profesore'])->name('logout.profesore');
});




