<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Profesor;
use App\Models\Asignatura;
use Illuminate\Support\Facades\DB;




class ProfesoresController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webprofesores()
    {
        return view('profesores');
    }

    public function datos($id)
    {
        $idC = Asignatura::select('asignaturas.id_curso','asignaturas.nombre as asignatura','cursos.nombre as curso')
        ->join('cursos', 'cursos.id', '=', 'asignaturas.id_curso')
        ->where('asignaturas.id', $id)
        ->get();

        $horasTotales = Asignatura::select(Asignatura::raw('(TIMESTAMPDIFF(WEEK, fecha_inicio, fecha_fin) +
        CASE WHEN WEEKDAY(fecha_inicio) > WEEKDAY(fecha_fin) THEN 2 ELSE 1 END) * COUNT(asignaturas.id) AS resultado'))
        ->join('horario_asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
        ->join('horarios', 'horario_asignaturas.id_horario_int', '=', 'horarios.id')
        ->where('asignaturas.id', $id)
        ->groupBy('asignaturas.fecha_fin', 'asignaturas.fecha_inicio') // Incluye 'asignaturas.fecha_fin' en GROUP BY
        ->get();

        $horasTotales = $horasTotales[0]['resultado'];

        $diasSemana = [
            'Lunes' => 0,
            'Martes' => 1,
            'Miércoles' => 2,
            'Jueves' => 3,
            'Viernes' => 4,
            'Sábado' => 5,
            'Domingo' => 6
        ];
        
        $dias = Asignatura::join('horario_asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
        ->join('horarios', 'horario_asignaturas.id_horario_int', '=', 'horarios.id')
        ->where('asignaturas.id', $id)
        ->pluck('horarios.dia')
        ->map(function ($dia) use ($diasSemana) {
            return $diasSemana[$dia];
        })
        ->toArray();
        // dd($dias);

        $fechaIni = Asignatura::where('id', $id)
        ->selectRaw('WEEKDAY(fecha_inicio) as inicio')
        ->get();

        $fechaIni = $fechaIni[0]['inicio'];

        $fechaFin = Asignatura::where('id', $id)
        ->selectRaw('WEEKDAY(fecha_fin) as fin')
        ->get();

        $fechaFin = $fechaFin[0]['fin'];

        $horasRest = 0;
        foreach ($dias as $dia) {
            // Accede a cada resultado individualmente aquí
            if($dia < $fechaIni){
                $horasRest++;
            }
            if($dia > $fechaFin){
                $horasRest++;
            }
            // dd($dia);
        }

        $horasTotales = $horasTotales - $horasRest;
        
        
        return view('datos', compact('id','idC','horasTotales'));
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
    public function indexprofesores(Request $request)
    {
        $filtro = $request->query('filtro');

        if (empty($filtro)) {
            $profesores = Profesor::paginate(5);
        } else {
            $profesores = Profesor::where('nombre', 'like', '%' . $filtro . '%')
                ->orWhere('apellido', 'like', '%' . $filtro . '%')
                ->orWhere('email', 'like', '%' . $filtro . '%')
                ->paginate(5);
        }

        return response()->json($profesores);
    }


    public function indexprofesoresload()
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
        if ($request->estado === "Desactivado") {
            $estado = false;
        }elseif ($request->estado === "Activado") {
            $estado = true;
        }
        $profesor->estado = $estado;
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

    public function profeClase()
{
    $asignatura = Asignatura::select('asignaturas.nombre as asignatura','cursos.nombre as curso','cursos.id as id')
    ->join('cursos', 'cursos.id', '=', 'asignaturas.id_curso')
    ->join('profesores', 'profesores.id', '=', 'asignaturas.id_profesor')
    ->join('horario_asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
    ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
    ->where('profesores.id', auth('profesor')->user()->id)
    ->whereRaw('TIME(NOW()) BETWEEN horarios.hora_inicio AND horarios.hora_fin')
    ->whereRaw('horarios.dia = CONCAT(ELT(WEEKDAY(now()) + 1, "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo"))')
    ->limit(1)
    ->get();

    if ($asignatura->isNotEmpty()) { // Verifica si hay resultados en la colección
        return response()->json([
            'tieneAsignatura' => true,
            'asignatura' => $asignatura->first()->asignatura,
            'curso' =>  $asignatura->first()->curso,
            'id' =>  $asignatura->first()->id// Accede al primer resultado
        ]);
    } else {
        return response()->json(['tieneAsignatura' => false]);
    }
}

public function des(Request $request)
{
    $profesores = $request->input('profesores');
    $profesoresJson = [];

    foreach ($profesores as $indice => $profesor) {
        $profesoresJson[] = ['id' => $profesor];
        $usuario = Profesor::where('id', $profesor)
        ->Where('estado', 1)
        ->first();

        if ($usuario) {
            $usuario->estado = 0;
            $usuario->save();
            // Actualizar el campo 'estado' del usuario
        }
    }
    
    echo json_encode($profesoresJson);
    
}
public function act(Request $request)
{
    $profesores = $request->input('profesores');
    $profesoresJson = [];

    foreach ($profesores as $indice => $profesor) {
        $profesoresJson[] = ['id' => $profesor];
        $usuario = Profesor::where('id', $profesor)
        ->Where('estado', 0)
        ->first();

        if ($usuario) {
            $usuario->estado = 1;
            $usuario->save();
            // Actualizar el campo 'estado' del usuario
        }
    }
    
    echo json_encode($profesoresJson);
    
}

    

}

// auth('profesor')->user()->id
