<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Curso;


class CursosController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webcursos()
    {
        return view('cursos');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexcursos()
    {
        $cursos = Curso::all();
        return response()->json($cursos);
    }
}