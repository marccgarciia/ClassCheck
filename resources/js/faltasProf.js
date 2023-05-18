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
                lista.innerHTML += `
                <tr>
                    <td>${falta.nombre}</td>
                    <td>${falta.apellido}</td>
                    <td>${falta.curso}</td>
                    <td>${falta.año}</td>
                    <td>${falta.por}</td>
                    <td><button onclick="faltasCalen('${falta.nombre}', '${falta.apellido}', '${falta.fecha_asistencia}', '${falta.curso}')">Ver</button></td>
                </tr>
                `;
            });            
        }
    }
    ajax.send();
}

function faltasCalen(nombre, apellido, fecha, curso) {
    // Crear un evento en el calendario para la falta de asistencia
    calendar.addEvent({
        title: nombre + ' ' + apellido + ' - ' + curso,
        start: fecha, // Ajustar la fecha según tus necesidades
        allDay: true // Indicar que el evento ocurre durante todo el día
    });
}

