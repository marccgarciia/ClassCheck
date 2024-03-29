<script src="{!! asset('js/faltasProf.js') !!}"></script>
<link rel="stylesheet" href="{!! asset('css/stylesfaltasprof.css') !!}">

<div class="row faltas">
    <div class="column2 table-wrapper" id='filtroP'>
        <div class="sep">
            <input type="text" class="inputbuscadornombres" placeholder="Buscar...">
            <input type="text" class="inputbuscadorcurso" placeholder="Curso">
            <input type="text" class="inputbuscadormodulo" placeholder="Modulo">
        </div>
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
        <ul class="pagination2" id="pagination-container"></ul>
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
</script>
