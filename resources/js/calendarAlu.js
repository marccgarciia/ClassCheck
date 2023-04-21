document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: "",
            center: "title"
        },
        locale: 'es',
        initialView: 'dayGridMonth'
    });
    calendar.render();
});
