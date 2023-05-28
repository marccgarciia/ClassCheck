<link rel="stylesheet" href="{!! asset('css/stylesdatos.css') !!}">
<p id="cursoId" style="display: none;">{{ $idC[0]['id_curso'] }}</p>
<p id="asignaturaId" style="display: none;">{{ $id }}</p>
<p id="horasTotales" style="display: none;">{{ $horasTotales }}</p>
<p id="fechaF" style="display: none;">{{ $fechas[0]->fin }}</p>
<p id="fechaI" style="display: none;">{{ $fechas[0]->inicio }}</p>



<!-- En el elemento HTML que carga tu script, agrega el atributo de datos con el valor del JSON -->
<script id="faltasAsistencia" type="application/json">{!! $faltasAsistencia !!}</script>

<div class="encabezado">
    <h1 id="tituloscan">{{ $idC[0]['asignatura'] }} - {{ $idC[0]['curso'] }}, Sesiones totales de la asignatura:
        {{ $horasTotales }}</h1>
</div>
<div id = "tabla" class="tabla">
    <div id="tabs">
        
    </div>

    <div id="meses">
        
    </div>
    
</div>
