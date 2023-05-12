<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profesor;


class ProfesoresController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webprofesores()
    {
        return view('profesores');
    }
    // CONTROLADOR PARA VER FALTAS 
    public function faltasprof()
    {
        return view('faltasprof');
    }
    // CONTROLADOR PARA VER HORARIO
    public function cursosprof()
    {
        return view('cursosprof');
    }
    // CONTROLADOR PARA VER DATOS 
    public function datosprof()
    {
        return view('datosprof');
    }

    public function pasarlista()
    {
        return view('pasarlista');
    }
    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexprofesores()
    {
        $profesores = Profesor::all();
        return response()->json($profesores);
    }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storeprofesores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:profesores,email',
            'password' => 'required|min:8',
            'estado' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profesor = new Profesor;
        $profesor->nombre = $request->nombre;
        $profesor->apellido = $request->apellido;
        $profesor->email = $request->email;
        $profesor->password = bcrypt($request->password);
        $profesor->estado = 1;
        $profesor->save();

        return response()->json($profesor);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updateprofesores(Request $request, $id)
    {
        $profesor = Profesor::find($id);
        if (!$profesor) {
            return response()->json(['message' => 'Profesor not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:profesores,email,' . $id,
            'estado' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $profesor->nombre = $request->nombre;
        $profesor->apellido = $request->apellido;
        $profesor->email = $request->email;
        // Comprobar si el campo password se ha proporcionado en la solicitud
        // if ($request->has('password')) {
        //     $profesor->password = bcrypt($request->password);
        // }
        $profesor->estado = $request->estado;
        $profesor->save();

        return response()->json($profesor);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroyprofesores($id)
    {
        $profesor = Profesor::findOrFail($id);
        $profesor->delete();
        return response()->json(['message' => 'Profesor deleted']);
    }

}
