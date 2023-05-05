<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\Escuela;
use App\Models\Profesor;
use App\Models\Asignatura;



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
        $cursos = Curso::with('escuela')->get();
        return response()->json($cursos);
    }

    public function cursosprofe()
    //->where('profesores.id','=',auth('profesor')->user()->id)
    {
        $cursos = Asignatura::select('asignaturas.*','cursos.nombre as curso')
        ->join('profesores','profesores.id','=','asignaturas.id_profesor')
        ->join('cursos','cursos.id','=','asignaturas.id_curso')
        ->where('profesores.id','=',auth('profesor')->user()->id)
        // ->groupBy('cursos.nombre')
        ->get();
        return response()->json($cursos);
    }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storecursos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'promocion' => 'required',
            'id_escuela' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $curso = new Curso;
        $curso->nombre = $request->nombre;
        $curso->promocion = $request->promocion;
        $curso->id_escuela = $request->id_escuela;
        $curso->save();

        return response()->json($curso);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updatecursos(Request $request, $id)
    {
        $curso = Curso::find($id);
        if (!$curso) {
            return response()->json(['message' => 'Curso not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'promocion' => 'required',
            'id_escuela' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $curso->nombre = $request->nombre;
        $curso->promocion = $request->promocion;
        $curso->id_escuela = $request->id_escuela;
        $curso->save();

        return response()->json($curso);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroycurso($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();
        return response()->json(['message' => 'Curso deleted']);
    }

    // CONTROLADOR PARA VER CURSOS
    public function escuelas()
    {
        $escuelas = Escuela::all();
        return response()->json($escuelas);
    }
}
