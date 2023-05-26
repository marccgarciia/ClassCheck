<script src="{!! asset('../resources/js/cursosP.js') !!}"></script>
<script src="{!! asset('../resources/js/datos.js') !!}"></script>

<div id="paneldecontrol">
    @yield('contenido')
    <ul class="box-info" id="resultado">
    </ul>
    <div class="info">
        <div class="infodiv">
            <h1><i class="fa-solid fa-circle-info"></i></h1>
            <p>En esta sección, tendrás la posibilidad de visualizar todos los cursos en los cuales estás asignado como
                docente. Al hacer clic en uno de ellos, se desplegará una lista detallada de las asignaturas que
                impartes en
                ese curso en particular.</p>
        </div>
        <div class="infodiv">
            <h1 style="font-size: 30px"><i class="fa-solid fa-circle-info"></i></h1>
            <p>Cuando selecciones una asignatura de un curso en particular, tendrás acceso a una tabla que presenta de
                manera organizada todas las ausencias registradas de los estudiantes matriculados en dicha clase.
                Además,
                podrás visualizar el porcentaje de faltas de cada estudiante y determinar si se encuentra en situación
                de
                suspensión debido a las mismas. Asimismo, es importante destacar que se ofrece la opción de visualizar
                las
                faltas clasificadas por meses.</p>
        </div>
    </div>
</div>

@section('contenido')
@endsection
<div id="resultadoexcel">

</div>
