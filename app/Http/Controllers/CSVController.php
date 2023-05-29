<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Profesore;
use App\Models\Profesor;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Escuela;
use App\Models\Asignatura;
use Illuminate\Http\Request;

class CSVController extends Controller
{
    public function exp(Request $request){
        $data = Alumno::join('cursos', 'alumnos.id_curso', '=', 'cursos.id')
        ->select('alumnos.nombre', 'alumnos.apellido', 'alumnos.email', 'alumnos.email_padre', 'alumnos.estado', 'cursos.nombre as curso')
        ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=alumnos.csv',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['nombre', 'apellido', 'email', 'email_padre', 'estado', 'curso']);

            foreach ($data as $row) {
                if ($row['estado'] == 1){
                    fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->email_padre, "Activado", $row->curso]);
                }else if ($row['estado'] == 0) {
                    fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->email_padre, "Desactivado", $row->curso]);
                }else {
                    fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->email_padre, "#!ERROR", $row->curso]);
                }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'alumnos.csv', $headers);
    }

    public function imp(Request $request)
    {

    // Verificar que se haya enviado un archivo CSV
    if ($request->hasFile('csv-file') && $request->file('csv-file')->isValid()) {
        // Obtener el archivo CSV
        $csvFile = $request->file('csv-file');

        // Leer los datos del archivo CSV y guardarlos en un array
        $csvData = array_map('str_getcsv', file($csvFile->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));

        // Verificar que el archivo contenga datos
        if (count($csvData) > 0) {
            // Obtener las columnas del archivo CSV
            $csvColumns = $csvData[0];
            // Verificar que el archivo contenga las columnas esperadas
            $csvColumns = array_map('utf8_encode', $csvColumns);
            $csvColumns[0] = substr($csvColumns[0], 6);
            if ($csvColumns === ['nombre', 'apellido', 'email', 'estado', 'curso']) {
                // Eliminar la primera fila del array, que contiene los nombres de las columnas
                array_shift($csvData);

                // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                foreach ($csvData as $rowData) {
                    // Obtener los valores de cada columna del archivo CSV

                    $nombre = $rowData[0];
                    $apellido = $rowData[1];
                    $email = $rowData[2];
                    $email_p = $rowData[3];
                    if ($rowData[4] === "Activado") {
                        $estado = 1;
                    }elseif ($rowData[4] === "Desactivado") {
                        $estado = 0;
                    }else{
                        $estado = 3;
                    }
                    $curso = $rowData[5];

                    // Verificar si ya existe un registro con el mismo correo electrónico
                    if (DB::table('alumnos')->where('email', $email)->exists()) {
                        // Si ya existe, no insertar un nuevo registro y mostrar un mensaje de advertencia
                        return "El correo electrónico $email del usuario $nombre ya existe en la base de datos.";
                        // \Log::warning($message);
                    }elseif ($estado === 3) {
                        return "El usuario $nombre no tiene un estado correcto";
                        // \Log::warning($message);
                    }else {
                        // Si no existe, insertar un nuevo registro
                        $id_curso = Curso::where('nombre', $curso)->value('id');
                        Alumno::insert([
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'email' => $email,
                            'password' => '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.',
                            'email_padre' => $email_p,
                            'estado' => $estado,
                            'id_curso' => $id_curso,
                        ]);
                    // Mostrar un mensaje de éxito
                    }
                }
                return 'Se han importado ' . count($csvData) . ' registros correctamente.';
            } else {
                // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                return 'El archivo debe contener las columnas ' . $csvColumns[0] . ', "apellido", "email",  "email_padre", "estado", "id_curso".';
            }
        } else {
            // Mostrar un mensaje de error en caso de que el archivo esté vacío
            return 'El archivo está vacío.';
        }
    } else {
        // Mostrar un mensaje de error en caso de que no se haya enviado un archivo CSV válido
        return 'Debe seleccionar un archivo CSV válido.';
    }
}


    public function expprof(Request $request){
        $data = Profesor::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=profesor.csv',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['nombre', 'apellido', 'email', 'estado']);

            foreach ($data as $row) {
            if ($row['estado'] == 1){
                fputcsv($file, [$row->nombre, $row->apellido, $row->email, "Activado"]);
            }else if ($row['estado'] == 0) {
                fputcsv($file, [$row->nombre, $row->apellido, $row->email, "Desactivado"]);
            }else {
                fputcsv($file, [$row->nombre, $row->apellido, $row->email, "#!ERROR"]);
            }
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'profesor.csv', $headers);
    }
    
    public function impprof(Request $request)
    {
    // Verificar que se haya enviado un archivo CSV
    if ($request->hasFile('csv-file') && $request->file('csv-file')->isValid()) {
        // Obtener el archivo CSV
        $csvFile = $request->file('csv-file');
    
        // Leer los datos del archivo CSV y guardarlos en un array
        $csvData = array_map('str_getcsv', file($csvFile->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    
        // Verificar que el archivo contenga datos
        if (count($csvData) > 0) {
            // Obtener las columnas del archivo CSV
            $csvColumns = $csvData[0];
            // Verificar que el archivo contenga las columnas esperadas
            $csvColumns = array_map('utf8_encode', $csvColumns);
            $csvColumns[0] = substr($csvColumns[0], 6);
            if ($csvColumns === ['nombre', 'apellido', 'email', 'estado']) {
                // Eliminar la primera fila del array, que contiene los nombres de las columnas
                array_shift($csvData);
    
                // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                foreach ($csvData as $rowData) {
                    // Obtener los valores de cada columna del archivo CSV
    
                    $nombre = $rowData[0];
                    $apellido = $rowData[1];
                    $email = $rowData[2];
                    if ($rowData[3] === "Activado") {
                        $estado = 1;
                    }elseif ($rowData[3] === "Desactivado") {
                        $estado = 0;
                    }
    
                    // Verificar si ya existe un registro con el mismo correo electrónico
                    if (DB::table('profesores')->where('email', $email)->exists()) {
                        // Si ya existe, no insertar un nuevo registro y mostrar un mensaje de advertencia
                        return "El correo electrónico $email ya existe en la base de datos.";
                        // \Log::warning($message);
                    } else {
                        // Si no existe, insertar un nuevo registro
                        Profesor::insert([
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'email' => $email,
                            'password' => '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.',
                            'estado' => $estado,
                        ]);
                    // Mostrar un mensaje de éxito
                    
                    }
                }
                return 'Se han importado ' . count($csvData) . ' registros correctamente.';
            } else {
                // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                return 'El archivo debe contener las columnas ' . $csvColumns[0] . ', "apellido", "email",  "email_padre", "estado", "id_curso".';
            }
        } else {
            // Mostrar un mensaje de error en caso de que el archivo esté vacío
            return 'El archivo está vacío.';
        }
    } else {
        // Mostrar un mensaje de error en caso de que no se haya enviado un archivo CSV válido
        return 'Debe seleccionar un archivo CSV válido.';
    }
    }
    public function expcur(Request $request){
        $data = Curso::join('escuelas', 'cursos.id_escuela', '=', 'escuelas.id')
            ->select('cursos.nombre as nombre', 'cursos.promocion as promocion', 'escuelas.nombre as escuela')
            ->get();
    
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=cursos.csv',
        ];
    
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['nombre', 'promocion', 'escuela']);
    
            foreach ($data as $row) {
                fputcsv($file, [$row->nombre, $row->promocion, $row->escuela]);
            }
    
            fclose($file);
        };
    
        return response()->streamDownload($callback, 'cursos.csv', $headers);
    }
    
    
    public function impcur(Request $request)
    {
    // Verificar que se haya enviado un archivo CSV
    if ($request->hasFile('csv-file') && $request->file('csv-file')->isValid()) {
        // Obtener el archivo CSV
        $csvFile = $request->file('csv-file');
    
        // Leer los datos del archivo CSV y guardarlos en un array
        $csvData = array_map('str_getcsv', file($csvFile->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    
        // Verificar que el archivo contenga datos
        if (count($csvData) > 0) {
            // Obtener las columnas del archivo CSV
            $csvColumns = $csvData[0];
            // Verificar que el archivo contenga las columnas esperadas
            $csvColumns = array_map('utf8_encode', $csvColumns);
            $csvColumns[0] = substr($csvColumns[0], 6);
            if ($csvColumns === ['nombre', 'promocion', 'escuela']) {
                // Eliminar la primera fila del array, que contiene los nombres de las columnas
                array_shift($csvData);
    
                // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                foreach ($csvData as $rowData) {
                    // Obtener los valores de cada columna del archivo CSV

                    $nombre = $rowData[0];
                    $promocion = $rowData[1];
                    $escuela = $rowData[2];
    
                    // Verificar si ya existe un registro con el mismo correo electrónico
                    if (DB::table('cursos')->where('nombre', $nombre)->exists()) {
                        // Si ya existe, no insertar un nuevo registro y mostrar un mensaje de advertencia
                        return "El curso $nombre ya existe en la base de datos.";
                        // \Log::warning($message);
                    } else {
                        // Si no existe, insertar un nuevo registro
                        $id_escuela = Escuela::where('nombre', $escuela)->value('id');
                        Curso::insert([
                            'nombre' => $nombre,
                            'promocion' => $promocion,
                            'id_escuela' => $id_escuela,
                        ]);
                    }
                }
                // Mostrar un mensaje de éxito
                return 'Se han importado ' . count($csvData) . ' registros correctamente.';
            } else {
                // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                return 'El archivo debe contener las columnas ' . $csvColumns[1] . ', "promocion", "escuela".';
            }
        } else {
            // Mostrar un mensaje de error en caso de que el archivo esté vacío
            return 'El archivo está vacío.';
        }
    } else {
        // Mostrar un mensaje de error en caso de que no se haya enviado un archivo CSV válido
        return 'Debe seleccionar un archivo CSV válido.';
    }
    }

    public function expas(Request $request){
        $data = Asignatura::join('profesores', 'asignaturas.id_profesor', '=', 'profesores.id')
        ->join('cursos', 'asignaturas.id_curso', '=', 'cursos.id')
        ->select('asignaturas.nombre as asignatura', 'profesores.email as profesor', 'cursos.nombre as curso')
        ->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=asignaturas.csv',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['asignatura', 'curso', 'profesor']);

            foreach ($data as $row) {
                fputcsv($file, [$row->asignatura, $row->curso, $row->profesor]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'cursos.csv', $headers);
    }
    
    public function impas(Request $request)
    {
    // Verificar que se haya enviado un archivo CSV
    if ($request->hasFile('csv-file') && $request->file('csv-file')->isValid()) {
        // Obtener el archivo CSV
        $csvFile = $request->file('csv-file');
    
        // Leer los datos del archivo CSV y guardarlos en un array
        $csvData = array_map('str_getcsv', file($csvFile->getPathname(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
    
        // Verificar que el archivo contenga datos
        if (count($csvData) > 0) {
            // Obtener las columnas del archivo CSV
            $csvColumns = $csvData[0];
            // Verificar que el archivo contenga las columnas esperadas
            $csvColumns = array_map('utf8_encode', $csvColumns);
            $csvColumns[0] = substr($csvColumns[0], 6);
            if ($csvColumns === ['asignatura', 'curso', 'profesor']) {
                // Eliminar la primera fila del array, que contiene los nombres de las columnas
                array_shift($csvData);
    
                // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                foreach ($csvData as $rowData) {
                    // Obtener los valores de cada columna del archivo CSV

                    $nombre = $rowData[0];
                    $curso = $rowData[1];
                    $profesor = $rowData[2];
    
                    // Verificar si ya existe un registro con el mismo correo electrónico
                    if (Asignatura::where('nombre', $nombre)->exists()) {
                        // Si ya existe, no insertar un nuevo registro y mostrar un mensaje de advertencia
                        return "El curso $nombre ya existe en la base de datos.";
                        // \Log::warning($message);
                    } else {
                        // Si no existe, insertar un nuevo registro
                        $id_curso = Curso::where('nombre', $curso)->value('id');
                        $id_profesor = Profesor::where('email', $profesor)->value('id');
                        Asignatura::insert([
                            'nombre' => $nombre,
                            'id_curso' => $id_curso,
                            'id_profesor' => $id_profesor,
                        ]);
                    }
                }
                // Mostrar un mensaje de éxito
                return 'Se han importado ' . count($csvData) . ' registros correctamente.';
            } else {
                // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                return 'El archivo debe contener las columnas ' . $csvColumns[0] . ', "promocion", "escuela".';
            }
        } else {
            // Mostrar un mensaje de error en caso de que el archivo esté vacío
            return 'El archivo está vacío.';
        }
    } else {
        // Mostrar un mensaje de error en caso de que no se haya enviado un archivo CSV válido
        return 'Debe seleccionar un archivo CSV válido.';
    }
    }

}
