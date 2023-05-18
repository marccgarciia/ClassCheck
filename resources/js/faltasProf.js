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
                if(id_tipo_asistencia == 2){
                    tipo = 'Falta';
                }else if(id_tipo_asistencia == 3){
                    tipo = 'Retraso';
                }
                lista.innerHTML += `
                <tr>
                    <td>${falta.nombre}</td>
                    <td>${falta.apellido}</td>
                    <td>${falta.curso}</td>
                    <td>${falta.fecha_asistencia}</td>
                    <td>${tipo}</td>
                    <td><button onclick="faltasCalen('${falta.id}', '${falta.nombre}', '${falta.apellido}', '${falta.fecha_asistencia}', '${falta.curso}')">Ver</button></td>
                </tr>
                `;
            });            
        }
    }
    ajax.send();
}

function faltasCalen(id, nombre, apellido, fecha, curso) {
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
  
    // Crear un nuevo evento en el calendario para la falta de asistencia
    calendar.addEvent({
        title: nombre + ' ' + apellido + ' - ' + curso,
        start: fecha, // Ajustar la fecha según tus necesidades
        allDay: true, // Indicar que el evento ocurre durante todo el día
        color: 'red', // Establecer el color del evento en rojo
        extendedProps: {
            falta: id,
        }
    });
}


