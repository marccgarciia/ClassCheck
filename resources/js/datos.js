        // Definición de la función "opentabla"
        function opentabla(evt, tablaName) {
            // Se obtienen todos los elementos de la clase "tablacontenido"
            var tablacontenido = document.getElementsByClassName("tablacontenido");
            // Se recorre cada elemento y se elimina la clase "show"
            for (var i = 0; i < tablacontenido.length; i++) {
                tablacontenido[i].classList.remove("show");
            }

            // Se obtienen todos los elementos de la clase "tablalinks"
            var tablalinks = document.getElementsByClassName("tablalinks");
            // Se recorre cada elemento y se elimina la clase "active"
            for (var i = 0; i < tablalinks.length; i++) {
                tablalinks[i].classList.remove("active");
            }

            // Se agrega la clase "show" al elemento con el ID "tablaName"
            document.getElementById(tablaName).classList.add("show");
            // Se agrega la clase "active" al elemento que activó el evento "evt"
            evt.currentTarget.classList.add("active");
        }

        // Activar la primera pestaña por defecto
        // Se agrega la clase "show" al elemento con ID "mayo"
        document.getElementById("mayo").classList.add("show");
        // Se agrega la clase "active" al primer elemento con la clase "tablalinks"
        document.getElementsByClassName("tablalinks")[0].classList.add("active");




        // La función resaltarFaltas se encarga de buscar en la tabla las celdas que contienen la letra 'F' y les cambia el color de fondo a rojo
        function resaltarFaltas() {
            // Obtener la tabla
            const table = document.querySelector('table');

            // Recorrer todas las filas de la tabla, excepto la primera (que contiene los encabezados)
            for (let i = 1; i < table.rows.length; i++) {
                // Recorrer todas las celdas de la fila actual
                for (let j = 0; j < table.rows[i].cells.length; j++) {
                    // Si el contenido de la celda es "F", establecer el fondo de la celda en rojo
                    if (table.rows[i].cells[j].textContent === 'F') {
                        table.rows[i].cells[j].style.backgroundColor = '#DB504A';
                    }
                    // Si el contenido de la celda es "P", establecer el fondo de la celda en verde
                    else if (table.rows[i].cells[j].textContent === 'P') {
                        table.rows[i].cells[j].style.backgroundColor = 'rgb(85, 151, 86)';
                    }
                    // Si el contenido de la celda es "R", establecer el fondo de la celda en amarillo
                    else if (table.rows[i].cells[j].textContent === 'R') {
                        table.rows[i].cells[j].style.backgroundColor = 'rgb(228, 166, 92)';
                    }
                }
            }
        }

        function listaClase(){
            let curso = document.getElementById('cursoId').textContent;
            let asignatura = document.getElementById('asignaturaId').textContent;
            let horasTotales = document.getElementById('horasTotales').textContent;
            // let faltasAsistencia = JSON.parse(document.getElementById('faltasAsistencia').textContent);
            var faltasAsistenciaElement = document.getElementById('faltasAsistencia');
            var faltasAsistenciaJSON = faltasAsistenciaElement.textContent;
            var faltasAsistencia = JSON.parse(faltasAsistenciaJSON);

            console.log(faltasAsistencia);
            console.log(curso)
            console.log(asignatura)
            console.log(horasTotales)

            let lista = document.getElementById("listaFaltas");
            var csrf_token = token.content;
            const ajax = new XMLHttpRequest();
            let formdata = new FormData();
            formdata.append('_token', csrf_token);
            formdata.append('curso', curso);
    
            ajax.open('POST', 'listaalumnos');
            ajax.onload = () => {
                if (ajax.status == 200) {
                    respuesta = JSON.parse(ajax.responseText);
                    console.log(respuesta);
                    let fechaAct = "";
                    let horarioAct = "";

                    // Crear un objeto para almacenar las faltas agrupadas
                    const faltasAgrupadas = {};

                    faltasAsistencia.forEach(function (falta) {
                        if (fechaAct != falta.fecha_asistencia || horarioAct != falta.id) {
                            document.getElementById('sesionesH').innerHTML += `<th>${falta.fecha_asistencia}</th>`;
                            fechaAct = falta.fecha_asistencia;
                            horarioAct = falta.id;
                        }

                        // Agrupar las faltas por fecha y ID
                        const clave = `${falta.fecha_asistencia}-${falta.id}`;
                        if (!faltasAgrupadas[clave]) {
                            faltasAgrupadas[clave] = [];
                        }
                        faltasAgrupadas[clave].push(falta);
                    });

                    respuesta.forEach(function (alumno) {
                        let faltaA = 0;
                        let fila = `<tr>
                            <td>${alumno.nombre} ${alumno.apellido}</td>
                            <td id="dia${alumno.id}"></td>`;
                        // Recorrer las faltas agrupadas por fecha y ID
                        for (const clave in faltasAgrupadas) {
                            const faltas = faltasAgrupadas[clave];
                            let faltaEncontrada = false;

                            faltas.forEach(function (falta) {
                                if (falta.id_alumno_asistencia === alumno.id) {
                                    if (falta.id_tipo_asistencia === 3) {
                                        fila += `<td>R</td>`;
                                        faltaA += 0.5;
                                    } else if (falta.id_tipo_asistencia === 2) {
                                        fila += `<td>F</td>`;
                                        faltaA += 1;
                                    }
                                    faltaEncontrada = true;
                                }
                            });

                            // Si no se encontró ninguna falta para la fecha y el ID actual, agregar una celda vacía
                            if (!faltaEncontrada) {
                                fila += `<td>P</td>`;
                            }
                        }

                        fila += `</tr>`;
                        lista.innerHTML += fila;
                        let porcentaje = calcularPorcentajeFaltas(horasTotales, faltaA);
                        // Actualizar porcentaje en todas las filas
                        document.getElementById('dia' + alumno.id).innerHTML = porcentaje + '%';

                        // Aplicar estilos de color según el porcentaje
                        if (porcentaje >= 0 && porcentaje < 12) {
                            document.getElementById('dia' + alumno.id).style.color = 'rgb(85, 151, 86)';
                        } else if (porcentaje >= 12 && porcentaje < 20) {
                            document.getElementById('dia' + alumno.id).style.color = 'rgb(228, 166, 92)';
                        } else {
                            document.getElementById('dia' + alumno.id).style.color = '#DB504A';
                        }
                    });

                    resaltarFaltas();
                }
            }

            ajax.send(formdata);
        }

        function calcularPorcentajeFaltas(horasTotales, faltas) {
            var porcentajeFaltas = (faltas * 100) / horasTotales;
            return porcentajeFaltas.toFixed(2); // Redondear el resultado a 2 decimales
          }
          