    <link rel="stylesheet" href="{!! asset('../resources/css/stylesdatos.css') !!}">

    <div class="tabla">
        <button class="tablalinks active" onclick="opentabla(event, 'mayo')">Mayo</button>
        <button class="tablalinks" onclick="opentabla(event, 'junio')">Junio</button>
        <button class="tablalinks" onclick="opentabla(event, 'julio')">Julio</button>

        <div id="mayo" class="tablacontenido show">
            <h3>Contenido de Mayo</h3>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>% de faltas</th>
                        <th id="dia">1</th>
                        <th id="dia">2</th>
                        <th id="dia">3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>10%</td>
                        <td id="dia">P</td>
                        <td id="dia">R</td>
                        <td id="dia">R</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>5%</td>
                        <td id="dia">F</td>
                        <td id="dia">P</td>
                        <td id="dia">R</td>
                    </tr>
                    <tr>
                        <td>David Lee</td>
                        <td>20%</td>
                        <td id="dia">P</td>
                        <td id="dia">F</td>
                        <td id="dia">P</td>
                    </tr>
                    <tr>
                        <td>Sara Johnson</td>
                        <td>7%</td>
                        <td id="dia">R</td>
                        <td id="dia">P</td>
                        <td id="dia">P</td>
                    </tr>
                    <tr>
                        <td>Alexander Kim</td>
                        <td>0%</td>
                        <td id="dia">P</td>
                        <td id="dia">P</td>
                        <td id="dia">F</td>
                    </tr>
                    <tr>
                        <td>Emily Chen</td>
                        <td>15%</td>
                        <td id="dia">F</td>
                        <td id="dia">F</td>
                        <td id="dia">F</td>
                    </tr>
                    <tr>
                        <td>Matthew Davis</td>
                        <td>8%</td>
                        <td id="dia">R</td>
                        <td id="dia">P</td>
                        <td id="dia">R</td>
                    </tr>
                    <tr>
                        <td>Amy Garcia</td>
                        <td>12%</td>
                        <td id="dia">F</td>
                        <td id="dia">F</td>
                        <td id="dia">F</td>
                    </tr>
                    <tr>
                        <td>Lucas Hernandez</td>
                        <td>18%</td>
                        <td id="dia">F</td>
                        <td id="dia">R</td>
                        <td id="dia">R</td>
                    </tr>
                    <tr>
                        <td>Jasmine Patel</td>
                        <td>3%</td>
                        <td id="dia">P</td>
                        <td id="dia">P</td>
                        <td id="dia">P</td>
                    </tr>
                </tbody>
            </table>

        </div>


        <div id="junio" class="tablacontenido">
            <h3>Contenido de Junio</h3>
            <p>Este es el contenido de la pestaña de Junio</p>
        </div>

        <div id="julio" class="tablacontenido">
            <h3>Contenido de Julio</h3>
            <p>Este es el contenido de la pestaña de Julio</p>
        </div>
    </div>





    <script>
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

        // Esperar a que se cargue la página y luego resaltar las faltas y presencias
        window.addEventListener('load', resaltarFaltas);
    </script>

