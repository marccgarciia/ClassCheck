function updatePagination() {
    var prevBtn = $('#pagination-prev');
    var nextBtn = $('#pagination-next');
    var pageButtons = '';
    currentPage = 1;
    console.log(currentPage);

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
        let filtro = buscador.value;
        if (!filtro) {
            listarFaltas('');
        } else {
            listarFaltas(filtro);
        }
    });

    // Control de eventos para el botón de página anterior
    prevBtn.click(function(event) {
        event.preventDefault();
        if (currentPage > 1) {
            currentPage--;
            let filtro = buscador.value;
            if (!filtro) {
                listarFaltas('');
            } else {
                listarFaltas(filtro);
            }
        }
    });

    // Control de eventos para el botón de página siguiente
    nextBtn.click(function(event) {
        event.preventDefault();
        if (currentPage < lastPage) {
            currentPage++;
            // listarFaltas();
            let filtro = buscador.value;
            if (!filtro) {
                listarFaltas('');
            } else {
                listarFaltas(filtro);
            }
        }
    });
}

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