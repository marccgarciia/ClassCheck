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
                        table.rows[i].cells[j].style.backgroundColor = '#7BD45F';
                    }
                    // Si el contenido de la celda es "R", establecer el fondo de la celda en amarillo
                    else if (table.rows[i].cells[j].textContent === 'R') {
                        table.rows[i].cells[j].style.backgroundColor = '#E4A65C';
                    }
                }
            }
        }

        // function calculoHoras(asignatura){
        //     alert(asignatura)
        // }

        function listaClase(){
            let curso = document.getElementById('cursoId').textContent;
            let asignatura = document.getElementById('asignaturaId').textContent;
            let horasTotales = document.getElementById('horasTotales').textContent;

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
                    respuesta.forEach(function (alumno) {
                        lista.innerHTML += `
                        <tr>
                            <td>${alumno.nombre} ${alumno.apellido}</td>
                            <td>10%</td>
                            <td id="dia">P</td>
                            <td id="dia">R</td>
                            <td id="dia">R</td>
                        </tr>
                        `
                        // <h1>${alumno.nombre} ${alumno.apellido}</h1>

                    });
                    resaltarFaltas()
                    // calculoHoras(asignatura)
                }
            }
            ajax.send(formdata);
        }