<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Curso;
use App\Models\Escuela;


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
    public function destroycursos($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();
        return response()->json(['message' => 'Usuario deleted']);
    }

    // CONTROLADOR PARA VER ESCUELA
    public function escuelas()
    {
        $escuelas = Escuela::all();
        return response()->json($escuelas);
    }
}
