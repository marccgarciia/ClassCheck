<script src="{!! asset('../resources/js/faltasProf.js') !!}"></script>
<h1> Nombre y apellido <h1>
<input type="text" name="buscador" id="buscador" placeholder="Buscador...">
<h1> Curso <h1>
<input type="text" name="buscadorCurso" id="buscadorCurso" placeholder="Buscador...">
<h1> Asignatura <h1>
 <input type="text" name="buscadorAsignatura" id="buscadorAsignatura" placeholder="Buscador...">
{{-- <input type="text" name="buscadorClase" id="buscadorClase" placeholder="Buscador..."> --}} 
<ul id="pagination" class="pagination"></ul>
<link rel="stylesheet" href="{!! asset('../resources/css/stylesfaltasprof.css') !!}">

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

document.getElementById('buscador').addEventListener("keyup", () => {
        let filtroNombre = document.getElementById('buscador').value;
        let filtroCurso = document.getElementById('buscadorCurso').value;
        let filtroAsignatura = document.getElementById('buscadorAsignatura').value;

        listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
    });

    document.getElementById('buscadorCurso').addEventListener("keyup", () => {
        let filtroNombre = document.getElementById('buscador').value;
        let filtroCurso = document.getElementById('buscadorCurso').value;
        let filtroAsignatura = document.getElementById('buscadorAsignatura').value;

        listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
    });

    document.getElementById('buscadorAsignatura').addEventListener("keyup", () => {
        let filtroNombre = document.getElementById('buscador').value;
        let filtroCurso = document.getElementById('buscadorCurso').value;
        let filtroAsignatura = document.getElementById('buscadorAsignatura').value;

        listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
    });
listarFaltas();


function listarFaltas(filtroNombre, filtroCurso, filtroAsignatura) {
     // Eliminar todos los eventos existentes en el calendario
    // Al filtrar o cambiar de página, se eliminan todos los eventos del calendario
    calendar.getEvents().forEach(function(event) {
        event.remove();
    });

    $.ajax({
        url: "listarFaltas",
        type: "GET",
        dataType: "json",
        data: {
            page: currentPage,
            filtroNombre: filtroNombre,
            filtroCurso: filtroCurso,
            filtroAsignatura: filtroAsignatura
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
            console.log("PAGINACION LOAD FALTAS")
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

function updatePagination() {
    var prevBtn = $('#pagination-prev');
    var nextBtn = $('#pagination-next');
    var pageButtons = '';
    currentPage = 1;
    console.log(currentPage);
    console.log(buscador.value);

    // Agrega botones numéricos para todas las páginas disponibles
    for (var i = 1; i <= lastPage; i++) {
        pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
    }

    // Actualiza el contenido de la lista desordenada con los botones numéricos
    $('#pagination').html(pageButtons);

    // Control de eventos para los botones numéricos
    $('.page-link').click(function(event) {
        event.preventDefault();
        currentPage = $(this).data('page');
        // listarFaltas();
        let filtroNombre = buscador.value;
        let filtroCurso = buscadorCurso.value;
        let filtroAsignatura = buscadorAsignatura.value;
        if (!filtroNombre && !filtroCurso && !filtroAsignatura) {
            listarFaltas('');
            console.log("0 filtro pag");
        } else {
            listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
            console.log("Filtro con pag OK");
        }
    });

    // Control de eventos para el botón de página anterior
    prevBtn.click(function(event) {
        event.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            let filtroNombre = buscador.value;
            let filtroCurso = buscadorCurso.value;
            let filtroAsignatura = buscadorAsignatura.value;
            if (!filtroNombre && !filtroCurso && !filtroAsignatura) {
                listarFaltas('');
                console.log("0 filtro pag");
            } else {
                listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
                console.log("Filtro con pag OK");
            }
        }
    });

    // Control de eventos para el botón de página siguiente
    nextBtn.click(function(event) {
        event.preventDefault();
        if (currentPage < lastPage) {
            currentPage++;
            // listarFaltas();
            let filtroNombre = buscador.value;
            let filtroCurso = buscadorCurso.value;
            let filtroAsignatura = buscadorAsignatura.value;
            if (!filtroNombre && !filtroCurso && !filtroAsignatura) {
                listarFaltas('');
                console.log("0 filtro pag");
            } else {
                listarFaltas(filtroNombre, filtroCurso, filtroAsignatura);
                console.log("Filtro con pag OK");
            }
        }
    });
}




</script>
