<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Escuela;


class EscuelaController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webescuelas()
    {
        return view('escuelas');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexcursos()
    {
        $escuelas = Escuela::all();
        return response()->json($escuelas);
    }

}