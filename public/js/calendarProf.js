document.addEventListener('DOMContentLoaded', function() {
    alert('hola');
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


window.addEventListener("load",()=>{
    console.log('Calendar loaded');
});