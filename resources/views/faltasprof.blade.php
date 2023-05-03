<div class="row">
    <div class="column2 table-wrapper" id='filtroP'>
        <table>
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Año</th>
                    <th scope="col">%</th>
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
        initialView: 'dayGridMonth'
    });
    calendar.render()
</script>