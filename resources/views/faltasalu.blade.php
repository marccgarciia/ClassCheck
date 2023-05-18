<ul class="box-info">

    <li>
        <i class='bx bxs-calendar-check'></i>
        <span class="texto">
            <h3>55</h3>
            <p>Total de Faltas</p>
        </span>
    </li>

    <li>
        <i class='bx bx-library'></i>
        <span class="texto">
            <h3>254</h3>
            <p>Total Asignaturas</p>
        </span>
    </li>

</ul>
<br>

<div class="grande">
    <div class="peque porcentaje">
        <h1>REDES</h1>
        <h1 id="por">10%</h1>
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
