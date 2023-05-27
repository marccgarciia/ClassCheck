<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Profesor;
use App\Models\Alumno;
use Carbon\Carbon;


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

    public function comprobarClase(){
        $asignatura = DB::table('horarios')
        ->select('horarios.hora_inicio', 'asignaturas.id AS idAS', 'asignaturas.nombre AS asignatura', 'cursos.nombre AS curso', 'cursos.id AS id')
        ->join('horario_asignaturas', 'horario_asignaturas.id_horario_int', '=', 'horarios.id')
        ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
        ->join('cursos', 'cursos.id', '=', 'asignaturas.id_curso')
        ->join('alumnos', 'alumnos.id_curso', '=', 'cursos.id')
        ->where('alumnos.id', auth('alumno')->user()->id)
        ->whereRaw('TIME(NOW()) BETWEEN horarios.hora_inicio AND horarios.hora_fin')
        ->whereRaw('horarios.dia = CONCAT(ELT(WEEKDAY(NOW()) + 1, "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado", "Domingo"))')
        ->whereDate('asignaturas.fecha_inicio', '<=', date('Y-m-d'))
        ->whereDate('asignaturas.fecha_fin', '>=', date('Y-m-d'))
        ->limit(1)
        ->get();
    

        if ($asignatura->isNotEmpty()) {
            $lista = DB::table('asistencias')
            ->join('alumnos', 'asistencias.id_alumno_asistencia', '=', 'alumnos.id')
            ->join('horario_asignaturas', 'asistencias.id_horarioasignatura_asistencia', '=', 'horario_asignaturas.id')
            ->join('asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
            ->join('horarios', 'horario_asignaturas.id_horario_int', '=', 'horarios.id')
            ->select('asistencias.*')
            ->where('alumnos.id', auth('alumno')->user()->id)
            ->where('asignaturas.id', $asignatura->first()->idAS)
            ->where('asistencias.id_tipo_asistencia', 2)
            ->where('horario_asignaturas.estado_lista', 1)
            ->whereDate('asistencias.fecha_asistencia', date('Y-m-d'))
            ->whereRaw('TIME(NOW()) BETWEEN horarios.hora_inicio AND horarios.hora_fin')
            ->get();
            if ($lista->isNotEmpty()) {
                return response()->json([
                    'pasadoLista' => false,
                    'tieneAsignatura' => true,
                    'asignatura' => $asignatura->first()->asignatura,
                    'curso' =>  $asignatura->first()->curso,
                    'id' =>  $asignatura->first()->id,
                    'idAs' => $asignatura->first()->idAS,
                    'hora' => $asignatura->first()->hora_inicio
                ]);
            }else{
                return response()->json([
                    'pasadoLista' => true,
                    'tieneAsignatura' => true,
                    'asignatura' => $asignatura->first()->asignatura,
                    'curso' =>  $asignatura->first()->curso,
                    'id' =>  $asignatura->first()->id,
                    'idAs' => $asignatura->first()->idAS,
                    'hora' => $asignatura->first()->hora_inicio
                ]);
            }          
        } else {
            return response()->json(['tieneAsignatura' => false]);
        }
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
                $asistencias = DB::table('asistencias')
                ->join('horario_asignaturas', 'asistencias.id_horarioasignatura_asistencia', '=', 'horario_asignaturas.id')
                ->join('asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
                ->select('asistencias.*', 'asignaturas.id as asId', 'asistencias.id_tipo_asistencia as Tipo')
                ->where('asignaturas.id', '=', $asignatura)
                ->where('asistencias.id_alumno_asistencia', '=', $alumno->id)
                ->where('asistencias.id_horarioasignatura_asistencia', '=', $resultado->id)
                ->get();
    
                if ($asistencias->isEmpty()) {
                    DB::insert('INSERT INTO asistencias (id_alumno_asistencia, id_profe_asistencia, id_horarioasignatura_asistencia, id_tipo_asistencia, fecha_asistencia) VALUES (?, ?, ?, ?, ?)', 
                    [$alumno->id, auth('profesor')->user()->id, $resultado->id, 2, $date]);
                }else{
                    if($asistencias->first()->Tipo == 3){
                        DB::table('asistencias')
                        ->join('horario_asignaturas', 'asistencias.id_horarioasignatura_asistencia', '=', 'horario_asignaturas.id')
                        ->join('asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
                        ->select('asistencias.*', 'asignaturas.id as asId', 'asistencias.id_tipo_asistencia as Tipo')
                        ->where('asignaturas.id', '=', $asignatura)
                        ->where('asistencias.id_alumno_asistencia', '=', $alumno->id)
                        ->where('asistencias.id_horarioasignatura_asistencia', '=', $resultado->id)
                        ->update(['id_tipo_asistencia' => 2]);
                    }
                }
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

    public function comprobarLista(Request $request)
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

        $alumnosSinResultados = [];

        foreach ($alumnos as $alumno) {
            $asistencias = DB::table('asistencias')
            ->join('horario_asignaturas', 'asistencias.id_horarioasignatura_asistencia', '=', 'horario_asignaturas.id')
            ->join('asignaturas', 'horario_asignaturas.id_asignatura_int', '=', 'asignaturas.id')
            ->select('asistencias.*', 'asignaturas.id as asId')
            ->where('asignaturas.id', '=', $asignatura)
            ->where('asistencias.id_alumno_asistencia', '=', $alumno->id)
            ->where('asistencias.id_horarioasignatura_asistencia', '=', $resultado->id)
            ->get();

            if ($asistencias->isEmpty()) {
                $alumnosSinResultados[] = $alumno->id;
            }
        }
        return response()->json($alumnosSinResultados);

    }

    public function pasarListaAlu(Request $request)
    {
        $fecha = $request->fecha;
        $hora = $request->hora;
        $asignatura = $request->asignatura;
        $alumno = $request->alumno;
        
        $horaActual = date('H:i:s');
        $horaLimite = strtotime($hora) + 10; // Variable hora + 10 segundos
        $fechaActual = date('Y-m-d');
        $fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');

        if (strtotime($horaActual) > $horaLimite || $fechaActual != $fecha) {
            return response()->json(['pasar' => false]);
        }

        $currentDateTime = date('H:i:s');

        $asistencia = DB::table('asistencias')
            ->join('horario_asignaturas', 'asistencias.id_horarioasignatura_asistencia', '=', 'horario_asignaturas.id')
            ->join('horarios', 'horario_asignaturas.id_horario_int', '=', 'horarios.id')
            ->where('asistencias.id_alumno_asistencia', $alumno)
            ->select('asistencias.*', 'horarios.hora_inicio')
            ->where('horario_asignaturas.id_asignatura_int', $asignatura)
            ->whereRaw('TIME(NOW()) BETWEEN horarios.hora_inicio AND horarios.hora_fin')
            ->whereRaw('asistencias.fecha_asistencia = CURDATE()')
            ->first();

            // dd($asistencia);
        if ($asistencia) {
            $horaInicio = $asistencia->hora_inicio;
            if (strtotime($currentDateTime) > strtotime($horaInicio) + 600) {
                // Actualizar el tipo de asistencia a 3
                // dd($asistencia->id);
                DB::table('asistencias')
                    ->where('id', $asistencia->id)
                    ->update(['id_tipo_asistencia' => 3]);
                    return response()->json(['pasar' => 'retraso']);

            } else {
                // Eliminar la falta
                DB::table('asistencias')->where('id', $asistencia->id)->delete();
                return response()->json(['pasar' => 'puntual']);

            }
        }else{
            return response()->json(['pasar' => 'error']);
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
