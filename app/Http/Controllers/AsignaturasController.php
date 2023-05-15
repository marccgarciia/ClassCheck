<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Profesor;


class AsignaturasController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webasignaturas()
    {
        return view('asignaturas');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexasignaturas()
    {
        $asignaturas = Asignatura::with('curso', 'profesor')->get();
        return response()->json($asignaturas);
    }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storeasignaturas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'id_curso' => 'nullable',
            'id_profesor' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $asignatura = new Asignatura;
        $asignatura->nombre = $request->nombre;
        $asignatura->id_curso = $request->id_curso;
        $asignatura->id_profesor = $request->id_profesor;
        $asignatura->save();

        return response()->json($asignatura);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updateasignaturas(Request $request, $id)
    {
        $asignatura = Asignatura::find($id);
        if (!$asignatura) {
            return response()->json(['message' => 'Asignatura not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'id_curso' => 'nullable',
            'id_profesor' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $asignatura->nombre = $request->nombre;
        $asignatura->id_curso = $request->id_curso;
        $asignatura->id_profesor = $request->id_profesor;
        $asignatura->save();

        return response()->json($asignatura);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroyasignaturas($id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->delete();
        return response()->json(['message' => 'Asignatura deleted']);
    }

    // CONTROLADOR PARA VER CURSOS
    public function cursosasignaturas()
    {
        $cursos = Curso::all();
        return response()->json($cursos);
    }

    // CONTROLADOR PARA VER PROFESORES
    public function profesores()
    {
        $profesores = Profesor::all();
        return response()->json($profesores);
    }

    public function countasignaturas()
    {
            $count = Asignatura::count();

            return response()->json([
                'count' => $count
        ]);
    }
}
