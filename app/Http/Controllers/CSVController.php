<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Profesore;
use App\Models\Alumno;
use Illuminate\Http\Request;

class CSVController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CSV  $cSV
     * @return \Illuminate\Http\Response
     */
    public function show(CSV $cSV)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CSV  $cSV
     * @return \Illuminate\Http\Response
     */
    public function edit(CSV $cSV)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CSV  $cSV
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CSV $cSV)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CSV  $cSV
     * @return \Illuminate\Http\Response
     */
    public function destroy(CSV $cSV)
    {
        //
    }

    public function exp(Request $request){
        $data = Alumno::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=alumnos.csv',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['nombre', 'apellido', 'email', 'email_padre', 'estado', 'id_curso']);

            foreach ($data as $row) {
                fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->email_padre, $row->estado, $row->id_curso]);
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
            $csvData = array_map('str_getcsv', file($csvFile->getPathname()));

            // Verificar que el archivo contenga datos
            if (count($csvData) > 0) {
                // Obtener las columnas del archivo CSV
                $csvColumns = $csvData[0];

                // Verificar que el archivo contenga las columnas esperadas
                if ($csvColumns === ['nombre', 'apellido', 'email', 'email_padre', 'estado', 'id_curso']) {
                    // Eliminar la primera fila del array, que contiene los nombres de las columnas
                    array_shift($csvData);

                    // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                    foreach ($csvData as $rowData) {
                        // Obtener los valores de cada columna del archivo CSV
                        $nombre = $rowData[0];
                        $apellido = $rowData[1];
                        $email = $rowData[2];
                        $email_p = $rowData[3];
                        $estado = $rowData[4];
                        $curso = $rowData[5];
                        
                        // Eliminar todos los registros de la tabla "alumnos"
                        // DB::table('alumnos')->truncate();

                        

                        // Insertar los datos en la tabla "alumnos"
                        DB::table('alumnos')->insert([
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'email' => $email,
                            'password' => '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.',
                            'email_padre' => $email_p,
                            'estado' => $estado,
                            'id_curso' => $curso,
                        ]);
                    }

                    // Mostrar un mensaje de éxito
                    return 'Se han importado ' . count($csvData) . ' registros correctamente.';
                } else {
                    // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                    return 'El archivo debe contener las columnas "nombre", "apellido" y "edad".';
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
        $data = Profesore::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=profesoresexp.csv',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fwrite($file, "\xEF\xBB\xBF");
            fputcsv($file, ['nombre', 'apellido', 'email', 'estado']);

            foreach ($data as $row) {
                fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->estado]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 'profesoresexp.csv', $headers);
    }
    public function impprof(Request $request)
    {

        // Verificar que se haya enviado un archivo CSV
        if ($request->hasFile('csv-file') && $request->file('csv-file')->isValid()) {
            // Obtener el archivo CSV
            $csvFile = $request->file('csv-file');

            // Leer los datos del archivo CSV y guardarlos en un array
            $csvData = array_map('str_getcsv', file($csvFile->getPathname()));

            // Verificar que el archivo contenga datos
            if (count($csvData) > 0) {
                // Obtener las columnas del archivo CSV
                $csvColumns = $csvData[0];

                // Verificar que el archivo contenga las columnas esperadas
                if ($csvColumns === ['nombre', 'apellido', 'email', 'estado']) {
                    // Eliminar la primera fila del array, que contiene los nombres de las columnas
                    array_shift($csvData);

                    // $importedRowsCount = 0; puede

                    // Iterar sobre los datos del archivo CSV e insertarlos en la base de datos
                    foreach ($csvData as $rowData) {
                        // Obtener los valores de cada columna del archivo CSV
                        $nombre = $rowData[0];
                        $apellido = $rowData[1];
                        $email = $rowData[2];
                        $estado = $rowData[3];

                        try {
                            DB::beginTransaction();
                            $existingProfesor = Profesore::where('nombre', $nombre)->where('apellido', $apellido)->where('email', $email)->exists();  
                            if (!$existingProfesor) {
                            // Insertar los datos en la tabla "profesores"
                                Profesore::insert([
                                    'nombre' => $nombre,
                                    'apellido' => $apellido,
                                    'email' => $email,
                                    'password' => '$2y$10$SvD7SENhYVhOog72mxGkJOHNizH.s7ubTneI.qxcYJ5D/AwsWJkx.',
                                    'estado' => $estado,
                                ]);
                            }
                            DB::commit();
                            return true;
                        } catch (\Exception $e) {
                            DB::rollback();
                            \Log::error("Error: " . $e->getMessage());
                            return false;
                        }

                    }

                    // Mostrar un mensaje de éxito
                    return 'Se han importado ' . count($csvData) . ' registros correctamente.';
                } else {
                    // Mostrar un mensaje de error en caso de que el archivo no contenga las columnas esperadas
                    return 'El archivo debe contener las columnas "nombre", "apellido" y "edad".';
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

//     public function expfiltroalu(Request $request){
//         $data = Alumno::where('materia', $nombrealu)->get();

//         $headers = [
//             'Content-Type' => 'text/csv',
//             'Content-Disposition' => 'attachment; filename=filtroalumno.csv',
//         ];

//         $callback = function() use ($data) {
//             $file = fopen('php://output', 'w');
//             fputcsv($file, ['nombre', 'apellido', 'email', 'password', 'email_padre', 'estado', 'id_curso']);

//             foreach ($data as $row) {
//                 fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->password, $row->email_padre, $row->estado, $row->id_curso]);
//             }

//             fclose($file);
//         };

//         return response()->streamDownload($callback, 'filtroalumno.csv', $headers);
//     }

//     public function expfiltromat(Request $request){
//         $data = Alumno::where('nombre', $nombremat)->get();

//         $headers = [
//             'Content-Type' => 'text/csv',
//             'Content-Disposition' => 'attachment; filename=filtromateria.csv',
//         ];

//         // $select= "SELECT nombre FROM tabla";

//         $callback = function() use ($data) {
//             $file = fopen('php://output', 'w');
//             fputcsv($file, ['nombre', 'apellido', 'email', 'password', 'email_padre', 'estado', 'id_curso']);

//             foreach ($data as $row) {
//                 fputcsv($file, [$row->nombre, $row->apellido, $row->email, $row->password, $row->email_padre, $row->estado, $row->id_curso]);
//             }

//             fclose($file);
//         };

//         return response()->streamDownload($callback, 'filtromateria.csv', $headers);
//     }
}