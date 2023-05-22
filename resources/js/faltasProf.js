function faltasCalen(id, nombre, apellido, fecha, curso, tipo) {
    // Verificar si el evento ya existe en el calendario
    var eventos = calendar.getEvents();
    var eventoExistente = eventos.find(function(evento) {
        return evento.extendedProps.falta === id;
    });

    // Si el evento existe, eliminarlo
    if (eventoExistente) {
        document.getElementById('verFalta' + id).innerHTML = "Ver";
        eventoExistente.remove();
        return; // Salir de la función, ya que se ha eliminado el evento
    }
    document.getElementById('verFalta' + id).innerHTML = "Dejar de ver";

    let colorF = "";
    if (tipo == 2) {
        colorF = '#DB504A';
    } else if (tipo == 3) {
        colorF = 'rgb(228, 166, 92)';
    }

    // Crear un nuevo evento en el calendario para la falta de asistencia
    calendar.addEvent({
        title: nombre + ' ' + apellido,
        start: fecha, // Ajustar la fecha según tus necesidades
        allDay: true, // Indicar que el evento ocurre durante todo el día
        color: colorF, // Establecer el color del evento
        extendedProps: {
            falta: id,
        }
    });
}