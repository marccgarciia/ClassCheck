<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
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


    public function listarFaltas(Request $request)
    {
        $filtro = $request->query('filtro');
        if(empty($filtro)){
            $faltas = DB::table('asistencias')
            ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
            ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
            ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
            ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
            ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
            ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
            ->where('asistencias.id_profe_asistencia', '=',auth('profesor')->user()->id)
            ->paginate(2);
        } else {
            $faltas = DB::table('asistencias')
            ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
            ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
            ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
            ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
            ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
            ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
            ->where('asistencias.id_profe_asistencia', '=', auth('profesor')->user()->id)
            ->when($filtro, function ($query, $filtro) {
                return $query->where(function ($q) use ($filtro) {
                    $q->where('alumnos.nombre', 'like', '%' . $filtro . '%')
                        ->orWhere('alumnos.apellido', 'like', '%' . $filtro . '%');
                });
            })
            ->paginate(2);
        }
        return response()->json($faltas);
    }
    // public function listarFaltas(Request $request)
    // {
    //     $filtroAlumno = $request->input('alumno');
    //     $filtroAsignatura = $request->input('asignatura');
    //     $filtroClase = $request->input('clase');
    //     if(empty($filtroAlumno) & empty($filtroAsignatura) & empty($filtroClase)){
    //         $faltas = DB::table('asistencias')
    //              ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
    //              ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
    //              ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
    //              ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
    //              ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
    //              ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
    //              ->where('asistencias.id_profe_asistencia', '=',auth('profesor')->user()->id)
    //              ->paginate(2);
    //             return response()->json($faltas);
    //     } else {
    //         $faltas = DB::table('asistencias')
    //         ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
    //         ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
    //         ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
    //         ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
    //         ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
    //         ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
    //         ->where('asistencias.id_profe_asistencia', '=', auth('profesor')->user()->id)
    //         ->when($filtroAlumno, function ($query, $filtroAlumno) {
    //             return $query->where(function ($q) use ($filtroAlumno) {
    //                 $q->where('alumnos.nombre', 'like', '%' . $filtroAlumno . '%')
    //                     ->orWhere('alumnos.apellido', 'like', '%' . $filtroAlumno . '%');
    //             });
    //         })
    //         ->when($filtroAsignatura, function ($query, $filtroAsignatura) {
    //             return $query->where(function ($q) use ($filtroAsignatura) {
    //             $q->where('asignaturas.nombre', 'like', '%' . $filtroAsignatura . '%');

    //             });
    //         })
    //         ->when($filtroClase, function ($query, $filtroClase) {
    //             return $query->where(function ($q) use ($filtroClase) {
    //                 $q->where('cursos.nombre', 'like', '%' . $filtroClase . '%')
    //                     ->orWhere('asignaturas.nombre', 'like', '%' . $filtroClase . '%');
    //             });
    //         })
    //         ->paginate(3);

    //         return response()->json($faltas);
    //     }
        
    // }


    // public function listarFaltas(Request $request)
    // {
    //     $filtroAlumno = $request->input('alumno');
    //     $filtroAsignatura = $request->input('asignatura');
    //     $filtroClase = $request->input('clase');
        
    //     $faltas = DB::table('asistencias')
    //         ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
    //         ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
    //         ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
    //         ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
    //         ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
    //         ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
    //         ->where('asistencias.id_profe_asistencia', '=', auth('profesor')->user()->id)
    //         ->when($filtroAlumno, function ($query, $filtroAlumno) {
    //             return $query->where(function ($q) use ($filtroAlumno) {
    //                 $q->where('alumnos.nombre', 'like', '%' . $filtroAlumno . '%')
    //                     ->orWhere('alumnos.apellido', 'like', '%' . $filtroAlumno . '%');
    //             });
    //         })
    //         ->when($filtroAsignatura, function ($query, $filtroAsignatura) {
    //             return $query->where(function ($q) use ($filtroAsignatura) {
    //             $q->where('asignaturas.nombre', 'like', '%' . $filtroAsignatura . '%');

    //             });
    //         })
    //         ->when($filtroClase, function ($query, $filtroClase) {
    //             return $query->where(function ($q) use ($filtroClase) {
    //                 $q->where('cursos.nombre', 'like', '%' . $filtroClase . '%')
    //                     ->orWhere('asignaturas.nombre', 'like', '%' . $filtroClase . '%');
    //             });
    //         })
    //         ->get();

    //     return response()->json($faltas);
    // }
    // public function listarFaltas()
    // {
    //     $faltas = DB::table('asistencias')
    //     ->join('alumnos', 'alumnos.id', '=', 'asistencias.id_alumno_asistencia')
    //     ->join('cursos', 'cursos.id', '=', 'alumnos.id_curso')
    //     ->join('horario_asignaturas', 'horario_asignaturas.id', '=', 'asistencias.id_horarioasignatura_asistencia')
    //     ->join('horarios', 'horarios.id', '=', 'horario_asignaturas.id_horario_int')
    //     ->join('asignaturas', 'asignaturas.id', '=', 'horario_asignaturas.id_asignatura_int')
    //     ->select('asistencias.*', 'alumnos.nombre', 'alumnos.apellido', 'cursos.nombre as curso', 'asignaturas.nombre as asignatura', 'horarios.hora_inicio', 'horarios.hora_fin')
    //     ->where('asistencias.id_profe_asistencia', '=',auth('profesor')->user()->id)
    //     ->get();
    //     return response()->json($faltas);
    // }
    
    public function countasignaturas()
    {
            $count = Asignatura::count();

            return response()->json([
                'count' => $count
        ]);
    }
}
