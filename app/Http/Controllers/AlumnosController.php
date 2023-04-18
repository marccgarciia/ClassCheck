<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Alumno;
use App\Models\Curso;


class AlumnosController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webalumnos()
    {
        return view('alumnos');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexalumnos()
    {
        $alumnos = Alumno::with('curso')->get();
        return response()->json($alumnos);
    }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storealumnos(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:alumnos,email',
            'password' => 'required|min:8',
            'email_padre' => 'required|email',
            'estado' => 'nullable',
            'id_curso' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $alumno = new Alumno;
        $alumno->nombre = $request->nombre;
        $alumno->apellido = $request->apellido;
        $alumno->email = $request->email;
        $alumno->password = bcrypt($request->password);
        $alumno->email_padre = $request->email_padre;
        $alumno->estado = 1;
        $alumno->id_curso = $request->id_curso;
        $alumno->save();

        return response()->json($alumno);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updatealumnos(Request $request, $id)
    {
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return response()->json(['message' => 'Usuario not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:alumnos,email,' . $id,
            'password' => 'required|min:8',
            'email_padre' => 'required|email',
            'estado' => 'nullable',
            'id_curso' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $alumno->nombre = $request->nombre;
        $alumno->apellido = $request->apellido;
        $alumno->email = $request->email;
        $alumno->password = bcrypt($request->password);
        $alumno->email_padre = $request->email_padre;
        $alumno->estado = $request->estado;
        $alumno->id_curso = $request->id_curso;
        $alumno->save();

        return response()->json($alumno);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroyalumnos($id)
    {
        $alumno = Alumno::findOrFail($id);
        $alumno->delete();
        return response()->json(['message' => 'Usuario deleted']);
    }

    // CONTROLADOR PARA VER CURSOS
    public function cursos()
    {
        $cursos = Curso::all();
        return response()->json($cursos);
    }
}
