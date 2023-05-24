<script src="{!! asset('../resources/js/cursosAlu.js') !!}"></script>

<ul class="box-info" id="resultado">
</ul>
<br>

<div class="grande">
    <div class="peque porcentaje">
        <p id="asignaturaAlu" style="font-size: 18px;"></p>
        <h1 id="porc" style="font-size: 50px;"><span id="porcentaje">%</span> de</h1>
        <h1 id="por">Faltas</h1>
    </div>
    <div class="peque cal">
        <div id='calendar'></div>
    </div>
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
