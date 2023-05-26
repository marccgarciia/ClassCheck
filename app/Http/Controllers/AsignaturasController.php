<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Alumno;


class AsignaturasController extends Controller
{
    // CONTROLADOR PARA LLEVAR A LA WEB
    public function webasignaturas()
    {
        return view('asignaturas');
    }

    // CONTROLADOR PARA MOSTRAR DATOS
    public function indexasignaturas(Request $request)
    {
        $filtro = $request->query('filtro');
        if(empty($filtro)){
            $asignaturas = Asignatura::with('curso', 'profesor')->paginate(5);
        } else {
            $asignaturas = Asignatura::with('curso', 'profesor')
            ->where('nombre', 'like', '%' . $filtro . '%')
            ->orWhereHas('curso', function($query) use ($filtro) {
                $query->where('nombre', 'like', '%' . $filtro . '%');
            })
            ->orWhereHas('profesor', function($query) use ($filtro) {
                $query->where('nombre', 'like', '%' . $filtro . '%');
            })
            ->paginate(5);
        }

        return response()->json($asignaturas);

        // $asignaturas = Asignatura::with('curso', 'profesor')->get();
        // return response()->json($asignaturas);
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

    public function listarFaltas(Request $req)
    {
        $buscar = $req->query('buscar');
        $curso = $req->query('curso');
        $modulo = $req->query('modulo');

        $where = "";

        $faltas = DB::table('asistencias')
        ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
        ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
        ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
        ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
        ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
        ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
        ->where('asistencias.id_profe_asistencia', '=',auth('profesor')->user()->id)
        ->orderBy('asistencias.fecha_asistencia');
        
        if (!empty($buscar)) {
            $faltas->where(function ($query) use ($buscar) {
                $query->where('alumnos.nombre', 'LIKE', $buscar . '%')
                    ->orWhere('alumnos.apellido', 'LIKE', $buscar . '%');
            });
        }
    
        if (!empty($curso)) {
            $faltas->where('cursos.nombre', 'LIKE', $curso . '%');
        }
    
        if (!empty($modulo)) {
            $faltas->where('asignaturas.nombre', 'LIKE', '%' . $modulo . '%');
        }
    
        $faltas = $faltas->get();


        return response()->json($faltas);
    }

    public function empezarClase(Request $request)
    {
        $curso = $request->curso;
        $hora = $request->hora;
        $asignatura = $request->asignatura;
        $date = date('Y-m-d');

        $alumnos = Alumno::select('alumnos.id as id')
        ->where('alumnos.id_curso', $curso)
        ->get();

        $resultado = DB::table('horario_asignaturas')
        ->select('horario_asignaturas.id as id', 'horario_asignaturas.*')
        ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
        ->where('horario_asignaturas.id_asignatura_int', $asignatura)
        ->where('horarios.hora_inicio', $hora)
        ->first();

        if($resultado->estado_lista != 1){
            foreach ($alumnos as $alumno) {
                DB::insert('INSERT INTO asistencias (id_alumno_asistencia, id_profe_asistencia, id_horarioasignatura_asistencia, id_tipo_asistencia, fecha_asistencia) VALUES (?, ?, ?, ?, ?)', 
                [$alumno->id, auth('profesor')->user()->id, $resultado->id, 2, $date]);
            }
            DB::table('horario_asignaturas')
            ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
            ->where('horario_asignaturas.id_asignatura_int', $asignatura)
            ->where('horarios.hora_inicio', $hora)
            ->update(['estado_lista' => 1]);
        }
    }

    public function finalizarClase(Request $request)
    {
        $curso = $request->curso;
        $hora = $request->hora;
        $asignatura = $request->asignatura;
        $date = date('Y-m-d');

        $resultado = DB::table('horario_asignaturas')
        ->select('horario_asignaturas.id as id', 'horario_asignaturas.*')
        ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
        ->where('horario_asignaturas.id_asignatura_int', $asignatura)
        ->where('horarios.hora_inicio', $hora)
        ->first();

        if($resultado->estado_lista == 1){
            DB::table('horario_asignaturas')
            ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
            ->where('horario_asignaturas.id_asignatura_int', $asignatura)
            ->where('horarios.hora_inicio', $hora)
            ->update(['estado_lista' => 0]);
        }
    }

    
    public function countasignaturas()
    {
            $count = Asignatura::count();

            return response()->json([
                'count' => $count
        ]);
    }

    public function getFaltas_Alu($id){
        $faltas = DB::table('asistencias')
        ->select('asistencias.*', 'asignaturas.id as asignatura', 'asignaturas.nombre as asNombre', 'horarios.hora_inicio', 'horarios.hora_fin')
        ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
        ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
        ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
        ->where('asistencias.id_alumno_asistencia', '=', auth('alumno')->user()->id)
        ->where('asignaturas.id', '=', $id)
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
        // $horas = datos($id);
    
        return response()->json([
            'horasTotales' => $horasTotales,
            'faltas' => $faltas
        ]);
            }
}
