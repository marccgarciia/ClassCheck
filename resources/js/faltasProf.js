// listarFaltas()

// function listarFaltas() {
//     let lista = document.getElementById("resultado");
//     const ajax = new XMLHttpRequest();

//     ajax.open('GET', 'listarFaltas');
//     ajax.onload = () => {
//         if (ajax.status == 200) {
//             // console.log(ajax.responseText);
//             respuesta = JSON.parse(ajax.responseText);
//             respuesta.forEach(function (falta) {
//                 let tipo = "";
//                 if (falta.id_tipo_asistencia == 2) {
//                     tipo = 'Falta';
//                 } else if (falta.id_tipo_asistencia == 3) {
//                     tipo = 'Retraso';
//                 }
//                 lista.innerHTML += `
//                 <tr class="fila-tabla">
//                     <td>${falta.nombre}</td>
//                     <td>${falta.apellido}</td>
//                     <td>${falta.curso}</td>
//                     <td>${falta.asignatura}</td>
//                     <td>${falta.hora_inicio} ${falta.hora_fin}</td>
//                     <td>${falta.fecha_asistencia}</td>
//                     <td>${tipo}</td>
//                     <td><button class="btn" id="verFalta${falta.id}" onclick="faltasCalen('${falta.id}', '${falta.nombre}', '${falta.apellido}', '${falta.fecha_asistencia}', '${falta.curso}', '${falta.id_tipo_asistencia}')">Ver</button></td>
//                 </tr>
//                 `;
//             });
//         }
//     }
//     ajax.send();
// }

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

// ÓSCAR

// PAGINACION
var pageSize = 4; // Número de elementos por página
var currentPage = 1; // Página actual

datos();

function MostrarActual(data) {
  var startIndex = (currentPage - 1) * pageSize;
  var endIndex = startIndex + pageSize;
  var paginatedData = data && data.slice(startIndex, endIndex); // Verificar si data existe antes de usar slice

  var tbody = document.querySelector("#resultado");
  tbody.innerHTML = "";

  if (paginatedData) {
    for (var i = 0; i < paginatedData.length; i++) {
        var row = document.createElement("tr");
        let tipo = "";
        if (paginatedData[i].id_tipo_asistencia == 2) {
            tipo = 'Falta';
        } else if (paginatedData[i].id_tipo_asistencia == 3) {
            tipo = 'Retraso';
        }
        row.innerHTML = `
        <td>${paginatedData[i].nombre}</td>
        <td>${paginatedData[i].apellido}</td>
        <td>${paginatedData[i].curso}</td>
        <td>${paginatedData[i].asignatura}</td>
        <td>${paginatedData[i].hora_inicio} <br> ${paginatedData[i].hora_fin}</td>
        <td>${paginatedData[i].fecha_asistencia}</td>
        <td>${tipo}</td>
        <td><button class="btn" id="verFalta${paginatedData[i].id}" onclick="faltasCalen('${paginatedData[i].id}', '${paginatedData[i].nombre}', '${paginatedData[i].apellido}', '${paginatedData[i].fecha_asistencia}', '${paginatedData[i].curso}', '${paginatedData[i].id_tipo_asistencia}')">Ver</button></td>

        `;
        tbody.appendChild(row);
    }
  }
}

function generatePagination(data) {
  var totalPages = data && Math.ceil(data.length / pageSize); // Verificar si data existe antes de acceder a length
  var paginationList = document.querySelector("#pagination-list");
  paginationList.innerHTML = "";

  if (totalPages) {
    for (var i = 1; i <= totalPages; i++) {
    var listItem = document.createElement("li");
    var link = document.createElement("a");
    link.textContent = i;
    link.href = "#";
    link.dataset.page = i;

    if (i === currentPage) {
      listItem.classList.add("active");
    }

    listItem.appendChild(link);
    paginationList.appendChild(listItem);
  }
}

  // Asignar evento de escucha a los enlaces de paginación
  var paginationLinks = document.querySelectorAll("#pagination-list a");
  paginationLinks.forEach(function (link) {
    link.addEventListener("click", changePage);
    console.log(link);
  });

}

function changePage(e) {
  e.preventDefault();
  var newPage = parseInt(e.target.dataset.page);
  console.log(newPage);
  if (newPage !== currentPage) {
    currentPage = newPage;
    console.log(responseData);
    // -----------------------------------------

    // -----------------------------------------
    // Volver a mostrar los datos en la página actualizada
    datos();
  }
}
var responseData; 
function datos() {
// Declarar responseData en un ámbito más amplio

var xhr = new XMLHttpRequest();
xhr.open('GET', 'listarFaltas', true);

xhr.onreadystatechange = function() {
  if (xhr.readyState === XMLHttpRequest.DONE) {
    if (xhr.status === 200) {
      // La solicitud se completó correctamente
      var responseData = JSON.parse(xhr.responseText);
      
      // Hacer algo con los datos obtenidos (ejemplo: mostrar en consola)
      console.log(responseData);
      MostrarActual(responseData);
      generatePagination(responseData);
    } else {
      // Ocurrió un error durante la solicitud
      console.error('Error en la solicitud:', xhr.status);
    }
  }
};
xhr.send();
}
