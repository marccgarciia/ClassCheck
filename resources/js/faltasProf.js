function listarFaltas(busqueda, curso, modulo, paginaActual, elementosPorPagina) {
    let lista = document.getElementById("resultado");
    const ajax = new XMLHttpRequest();

    // Calcular el índice de inicio y fin de los elementos en la página actual
    const indiceInicio = (paginaActual - 1) * elementosPorPagina;
    const indiceFin = indiceInicio + elementosPorPagina;

    ajax.open('GET', 'listarFaltas?buscar=' + busqueda + '&curso=' + curso + '&modulo=' + modulo);
    ajax.onload = () => {
        if (ajax.status == 200) {
            const inputBusqueda = document.querySelector('.inputbuscadornombres');
            const inputCurso = document.querySelector('.inputbuscadorcurso');
            const inputModulo = document.querySelector('.inputbuscadormodulo');
            inputBusqueda.addEventListener('keyup', buscar);
            inputCurso.addEventListener('keyup', buscar);
            inputModulo.addEventListener('keyup', buscar);
            respuesta = JSON.parse(ajax.responseText);
            console.log(respuesta);
            lista.innerHTML = '';

            // Obtener solo los elementos correspondientes a la página actual
            const elementosPagina = respuesta.slice(indiceInicio, indiceFin);

            elementosPagina.forEach(function (falta) {
                let tipo = "";
                if (falta.id_tipo_asistencia == 2) {
                    tipo = 'Falta';
                } else if (falta.id_tipo_asistencia == 3) {
                    tipo = 'Retraso';
                }

                lista.innerHTML += `
                <tr class="fila-tabla">
                    <td>${falta.nombre}</td>
                    <td>${falta.apellido}</td>
                    <td>${falta.curso}</td>
                    <td>${falta.asignatura}</td>
                    <td>${falta.hora_inicio} ${falta.hora_fin}</td>
                    <td>${falta.fecha_asistencia}</td>
                    <td>${tipo}</td>
                    <td><button class="btn" id="verFalta${falta.id}" onclick="faltasCalen('${falta.id}', '${falta.nombre}', '${falta.apellido}', '${falta.fecha_asistencia}', '${falta.curso}', '${falta.id_tipo_asistencia}')">Ver</button></td>
                </tr>
                `;
            });

            // Calcular el número total de páginas
            const totalPaginas = Math.ceil(respuesta.length / elementosPorPagina);

            // Generar los botones de paginación dinámicamente
            const paginationContainer = document.getElementById("pagination-container");
            paginationContainer.innerHTML = '';

            for (let i = 1; i <= totalPaginas; i++) {
                const button = document.createElement('button');
                button.innerText = i;
                button.addEventListener('click', () => {
                    listarFaltas(busqueda, curso, modulo, i, elementosPorPagina);
                });
                paginationContainer.appendChild(button);
            }
        }
    }
    ajax.send();
}

// Ejemplo de uso para mostrar 5 elementos por página y comenzar en la página 1
listarFaltas('', '', '', 1, 5);




function faltasCalen(id, nombre, apellido, fecha, curso, tipo) {
    // Verificar si el evento ya existe en el calendario
    var eventos = calendar.getEvents();
    var eventoExistente = eventos.find(function (evento) {
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


function buscar(event) {
    // console.log(event);
    const busqueda = document.querySelector('.inputbuscadornombres').value
    const curso = document.querySelector('.inputbuscadorcurso').value;
    const modulo = document.querySelector('.inputbuscadormodulo').value;
    // console.log(busqueda,curso,modulo);
    listarFaltas(busqueda, curso, modulo, 1, 5);
}
