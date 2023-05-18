listarFaltas()

function listarFaltas(){
    let lista = document.getElementById("resultado");
    const ajax = new XMLHttpRequest();

    ajax.open('GET', 'listarFaltas');
    ajax.onload = () => {
        if (ajax.status == 200) {
            // console.log(ajax.responseText);
            respuesta = JSON.parse(ajax.responseText);
            console.log(respuesta);
            respuesta.forEach(function (falta) {
                let tipo = "";
                if(falta.id_tipo_asistencia == 2){
                    tipo = 'Falta';
                }else if(falta.id_tipo_asistencia == 3){
                    tipo = 'Retraso';
                }
                lista.innerHTML += `
                <tr>
                    <td>${falta.nombre}</td>
                    <td>${falta.apellido}</td>
                    <td>${falta.curso}</td>
                    <td>${falta.asignatura}</td>
                    <td>${falta.hora_inicio} - ${falta.hora_fin}</td>
                    <td>${falta.fecha_asistencia}</td>
                    <td>${tipo}</td>
                    <td><button onclick="faltasCalen('${falta.id}', '${falta.nombre}', '${falta.apellido}', '${falta.fecha_asistencia}', '${falta.curso}', '${falta.id_tipo_asistencia}')">Ver</button></td>
                </tr>
                `;
            });            
        }
    }
    ajax.send();
}

function faltasCalen(id, nombre, apellido, fecha, curso, tipo) {
    // Verificar si el evento ya existe en el calendario
    var eventos = calendar.getEvents();
    var eventoExistente = eventos.find(function(evento) {
        return evento.extendedProps.falta === id;
    });
  
    // Si el evento existe, eliminarlo
    if (eventoExistente) {
        eventoExistente.remove();
        return; // Salir de la función, ya que se ha eliminado el evento
    }

    let colorF = "";
    if(tipo == 2){
        colorF = '#DB504A';
    }else if(tipo == 3){
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


