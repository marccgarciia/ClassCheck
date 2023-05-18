<link rel="stylesheet" href="{!! asset('../resources/css/stylesdatos.css') !!}">
<p id="cursoId" style="display: none;">{{ $idC[0]['id_curso'] }}</p>
<p id="asignaturaId" style="display: none;">{{ $id }}</p>
<p id="horasTotales" style="display: none;">{{ $horasTotales }}</p>

    <div class="encabezado">
    <h1>{{ $idC[0]['asignatura'] }} - {{ $idC[0]['curso'] }}, Sesiones totales de la asignatura: {{ $horasTotales }}</h1>
    </div>
    <div class="tabla">
        <button class="tablalinks active" onclick="opentabla(event, 'mayo')">Mayo</button>
        <button class="tablalinks" onclick="opentabla(event, 'junio')">Junio</button>
        <button class="tablalinks" onclick="opentabla(event, 'julio')">Julio</button>

        <div id="mayo" class="tablacontenido show">
            <h3>Contenido de Mayo</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>% de faltas</th>
                        <div id="sesiones">
                            <th id="dia">1</th>
                            <th id="dia">2</th>
                            <th id="dia">3</th>
                        </div>
                    </tr>
                </thead>
                <tbody id="listaFaltas">

                </tbody>
            </table>

        </div>


        <div id="junio" class="tablacontenido">
            <h3>Contenido de Junio</h3>
            <p>Este es el contenido de la pestaña de Junio</p>
        </div>

        <div id="julio" class="tablacontenido">
            <h3>Contenido de Julio</h3>
            <p>Este es el contenido de la pestaña de Julio</p>
        </div>
    </div>