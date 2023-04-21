<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;


class AdministradoresController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webadministradores()
    {
        return view('administradores');
    }

    public function webpanel()
    {
        return view('webpanel');
    }
    
    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexadministradores()
    {
        $administradores = Admin::all();
        return response()->json($administradores);
    }

    // CONTROLADOR PARA INSERTAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function storeadministradores(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:profesores,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $administrador = new Admin;
        $administrador->nombre = $request->nombre;
        $administrador->apellido = $request->apellido;
        $administrador->email = $request->email;
        $administrador->password = bcrypt($request->password);
        $administrador->save();

        return response()->json($administrador);
    }

    // CONTROLADOR PARA EDITAR DATOS CON VALIDACION DE CAMPOS VACIOS/FORMATO E-MAIL/E-MAIL EXISTENTE
    public function updateadministradores(Request $request, $id)
    {
        $administrador = Admin::find($id);
        if (!$administrador) {
            return response()->json(['message' => 'Adminstrador not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|alpha',
            'apellido' => 'required',
            'email' => 'required|email|unique:profesores,email,' . $id,
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $administrador->nombre = $request->nombre;
        $administrador->apellido = $request->apellido;
        $administrador->email = $request->email;
        $administrador->password = bcrypt($request->password);
        $administrador->save();

        return response()->json($administrador);
    }

    // CONTROLADOR PARA ELIMINAR DATOS
    public function destroyadministradores($id)
    {
        $administrador = Admin::findOrFail($id);
        $administrador->delete();
        return response()->json(['message' => 'Adminstrador deleted']);
    }
}
