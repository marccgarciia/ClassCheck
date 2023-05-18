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

    // CONTROLADOR PARA VER FALTAS 
    public function faltasalu()
    {
        return view('faltasalu');
    }
    // CONTROLADOR PARA VER HORARIO
    public function horarioalu()
    {
        return view('horarioalu');
    }
    // CONTROLADOR PARA VER DATOS 
    public function datosalu()
    {
        return view('datosalu');
    }

    // CONTROLADOR PARA VER SCANER 
    public function scanalu()
    {
        return view('scanalu');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexalumnos(Request $request)
    {
        $filtro = $request->query('filtro');
        if(empty($filtro)){
            $alumnos = Alumno::with('curso')->paginate(10);

        } else {
            $alumnos = Alumno::with('curso')
                ->where('nombre', 'like', '%' . $filtro . '%')
                ->orWhere('apellido', 'like', '%' . $filtro . '%')
                ->orWhere('email', 'like', '%' . $filtro . '%')
                ->orWhere('email_padre', 'like', '%' . $filtro . '%')
                ->orWhereHas('curso', function($query) use ($filtro) {
                    $query->where('nombre', 'like', '%' . $filtro . '%');
                })    
                ->paginate(10);
        }
        return response()->json($alumnos);
        // OLD, RECUPERAR SI NO SIRVE MI CODIGO Y QUITAR LOS REQUEST
        // $alumnos = Alumno::with('curso')->get();
        // return response()->json($alumnos);
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

        // Comprobar si el campo password se ha proporcionado en la solicitud
        // if ($request->has('password')) {
        //     $alumno->password = bcrypt($request->password);
        // }

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
    public function cursosalumnos()
    {
        $cursos = Curso::all();
        return response()->json($cursos);
    }

    public function countalu()
    {
            $count = Alumno::count();

            return response()->json([
                'count' => $count
        ]);
    }
}
