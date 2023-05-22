<script src="{!! asset('../resources/js/faltasProf.js') !!}"></script>
<h1> Nombre y apellido <h1>
<input type="text" name="buscador" id="buscador" placeholder="Buscador...">
<h1> Curso <h1>
<input type="text" name="buscadorCurso" id="buscadorCurso" placeholder="Buscador...">
{{-- <input type="text" name="buscadorAsignatura" id="buscadorAsignatura" placeholder="Buscador...">
<input type="text" name="buscadorClase" id="buscadorClase" placeholder="Buscador..."> --}}
<ul id="pagination" class="pagination"></ul>

<div class="row faltas">
    <div class="column2 table-wrapper" id='filtroP'>
        <table>
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Módulo</th>
                    <th scope="col">Sesión</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Faltas</th>
                </tr>
            </thead>
            
            <tbody class="tbody" id="resultado">

            </tbody>
        </table>
    </div>
    <div class="column2" id='calendar'></div>
</div>

<script>
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "",
            center: "title"
        },
        locale: 'es',
        initialView: 'dayGridMonth',
        firstDay: 1 // 1 representa el lunes
    });
    calendar.render();

var currentPage = 1;
var lastPage = 1;

buscador.addEventListener("keyup", () => {
    let filtro = buscador.value;
    if (!filtro) {
        listarFaltas('')
    } else {
        listarFaltas(filtro);
    }
})
listarFaltas();


function listarFaltas(filtro) {
    $.ajax({
        url: "listarFaltas",
        type: "GET",
        dataType: "json",
        data: {
            page: currentPage,
            filtro: filtro
        },
        success: function(data) {
            console.log(data);
            var tableRows = '';
            var tipo = "";

            $.each(data.data, function(i, falta) {

                if (falta.id_tipo_asistencia == 2) {
                    falta.id_tipo_asistencia = "Falta";
                } else if (falta.id_tipo_asistencia == 3) {
                    falta.id_tipo_asistencia = "Retraso";
                }

                tableRows += '<tr>';
                tableRows += '<td>' + falta.nombre + '</td>';
                tableRows += '<td>' + falta.apellido + '</td>';
                tableRows += '<td>' + falta.curso + '</td>';
                tableRows += '<td>' + falta.asignatura + '</td>';
                tableRows += '<td>' + falta.hora_inicio + '-' + falta.hora_fin + '</td>';
                tableRows += '<td>' + falta.fecha_asistencia + '</td>';
                tableRows += '<td>' + falta.id_tipo_asistencia + '</td>';
                tableRows += '<td><button id="verFalta' + falta.id + '" onclick="faltasCalen(\'' + falta.id + '\', \'' + falta.nombre + '\', \'' + falta.apellido + '\', \'' + falta.fecha_asistencia + '\', \'' + falta.curso + '\', \'' + falta.id_tipo_asistencia + '\')">Ver</button></td>';
                tableRows += '</tr>';
            });
            $('#resultado').html(tableRows);
            currentPage = data.current_page; // Actualiza el número de página actual
            lastPage = data.last_page; // Actualiza el número de la última página
            console.log("PAGINACION LOAD ASIGNATURAS")
            console.log(currentPage);
            console.log(lastPage);
            console.log("-------");
            // Actualiza los controles de paginación
            updatePagination();
        },
        error: function(error) {
            console.error(error);
        }
    });
}



</script>