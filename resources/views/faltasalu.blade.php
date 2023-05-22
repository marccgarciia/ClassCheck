<script src="{!! asset('../resources/js/cursosAlu.js') !!}"></script>

<ul class="box-info" id="resultado">
</ul>
<br>

<div class="grande">
    <div class="peque porcentaje">
        <p id="asignaturaAlu" style="font-size: 18px;"></p>
        <h1 id="porcentaje" style="font-size: 23px;">% de</h1>
        <h1 id="por" style="font-size: 21px;">Faltas</h1>
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
