// Definición de la función "opentabla"
function opentabla(evt, tablaName) {
    var tablacontenido = document.getElementsByClassName("tablacontenido");
    for (var i = 0; i < tablacontenido.length; i++) {
      tablacontenido[i].classList.remove("show");
    }
  
    var tablalinks = document.getElementsByClassName("tablalinks");
    for (var i = 0; i < tablalinks.length; i++) {
      tablalinks[i].classList.remove("active");
    }
  
    document.getElementById(tablaName).classList.add("show");
    evt.currentTarget.classList.add("active");
  }
  
  document.getElementById("mayo").classList.add("show");
  document.getElementsByClassName("tablalinks")[0].classList.add("active");
  
  function resaltarFaltas() {
    const table = document.querySelector("table");
  
    for (let i = 1; i < table.rows.length; i++) {
      for (let j = 0; j < table.rows[i].cells.length; j++) {
        if (table.rows[i].cells[j].textContent === "F") {
          table.rows[i].cells[j].style.backgroundColor = "#DB504A";
        } else if (table.rows[i].cells[j].textContent === "P") {
          table.rows[i].cells[j].style.backgroundColor = "#7BD45F";
        } else if (table.rows[i].cells[j].textContent === "R") {
          table.rows[i].cells[j].style.backgroundColor = "#E4A65C";
        }
      }
    }
  }
  
  function listaClase() {
    let curso = document.getElementById("cursoId").textContent;
    let asignatura = document.getElementById("asignaturaId").textContent;
    let horasTotales = document.getElementById("horasTotales").textContent;
    var faltasAsistenciaElement = document.getElementById("faltasAsistencia");
    var faltasAsistenciaJSON = faltasAsistenciaElement.textContent;
    var faltasAsistencia = JSON.parse(faltasAsistenciaJSON);
  
    console.log(faltasAsistencia);
    console.log(curso);
    console.log(asignatura);
    console.log(horasTotales);
  
    let lista = document.getElementById("listaFaltas");
    var csrf_token = token.content;
    const ajax = new XMLHttpRequest();
    let formdata = new FormData();
    formdata.append("_token", csrf_token);
    formdata.append("curso", curso);
  
    ajax.open("POST", "listaalumnos");
    ajax.onload = () => {
      if (ajax.status == 200) {
        respuesta = JSON.parse(ajax.responseText);
        console.log(respuesta);
  
        var faltasPorDia = {};
        faltasAsistencia.forEach(function (falta) {
          var fecha = falta.fecha_asistencia;
          var idAlumno = falta.id_alumno_asistencia;
          var hora = falta.hora_asistencia;
          var clave = fecha + "-" + hora;
  
          if (!faltasPorDia[clave]) {
            faltasPorDia[clave] = [];
          }
  
          faltasPorDia[clave].push(idAlumno);
        });
  
        faltasAsistencia.forEach(function (falta) {
          var clave = falta.fecha_asistencia + "-" + falta.hora_asistencia;
  
          if (faltasPorDia[clave] && faltasPorDia[clave].includes(alumno.id)) {
            if (falta.id_tipo_asistencia === 3) {
              fila += `<td>R</td>`;
              faltaA += 0.5;
            } else if (falta.id_tipo_asistencia === 2) {
              fila += `<td>F</td>`;
              faltaA += 1;
            }
          } else {
            fila += `<td>P</td>`;
          }
        });
  
        respuesta.forEach(function (alumno) {
          var fila = `<tr>
            <td>${alumno.nombre_alumno}</td>
            <td>${alumno.apellido_alumno}</td>`;
            
          var faltaA = 0;
  
          faltasAsistencia.forEach(function (falta) {
            var clave = falta.fecha_asistencia + "-" + falta.hora_asistencia;
  
            if (faltasPorDia[clave] && faltasPorDia[clave].includes(alumno.id)) {
              if (falta.id_tipo_asistencia === 3) {
                fila += `<td>R</td>`;
                faltaA += 0.5;
              } else if (falta.id_tipo_asistencia === 2) {
                fila += `<td>F</td>`;
                faltaA += 1;
              }
            } else {
              fila += `<td>P</td>`;
            }
          });
  
          var porcentajeFaltas = (faltaA / horasTotales) * 100;
          fila += `<td>${faltaA}</td><td>${porcentajeFaltas.toFixed(2)}%</td></tr>`;
          lista.innerHTML += fila;
        });
  
        resaltarFaltas();
      }
    };
  
    ajax.send(formdata);
  }
  

        function calcularPorcentajeFaltas(horasTotales, faltas) {
            var porcentajeFaltas = (faltas * 100) / horasTotales;
            return porcentajeFaltas.toFixed(2); // Redondear el resultado a 2 decimales
          }
          