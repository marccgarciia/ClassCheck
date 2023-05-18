<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
    <button id="btn-exportar" class="btn">Exportar CSV</button>

    <div class="importar">
        <form id="import-form" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv-file" required>
            <button type="submit" class="btn">Importar</button>

        </form>
    </div>
    <div id="cursos">
    <div id="import-results"></div>
        {{-- Filtro para filtrar por cursos --}}
        {{-- <select id="select-filtro">
            <option value="">Filtrar por curso</option>
        </select> --}}

        <table class="table">
            <thead>

                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Promocion</th>
                    <th scope="col">Escuela</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <button class="btn" onclick="location.href='#asignaturas1'">Insertar</button>
        <div id="asignaturas1" class="modal">
            <div class="modal__content5">
                <form action="cursos" method="POST" id="form-insert">
                    <h2 class="text12">Formulario de Insertar</h2>
                    @csrf
                    <div>
                    <input type="text" name="nombre" placeholder="Nombre">
                    <p id="nombre"></p>
                    </div>
                    <div>
                    <input type="text" name="promocion" placeholder="Promoción">
                    <p id="pr"></p>
                    </div>
                    <div>
                    <select id="escuela" name="id_escuela">
                        <option value="">Selecciona un escuela</option>
                    </select>
                    <p id="es"></p>
                    </div>
                    <button type="submit" class="btn12">Insertar</button>
                </form>
                <a href="#" id="cerrar" class="modal__close1">&times;</a>
            </div>
        </div>
    </div>


    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <div id="asignaturas2" class="modal2">
        <div class="modal__content6">
            <form action="cursos" method="POST" id="form-edit" style="display:none;">
                <h2 class="text13">Formulario de Editar</h2>
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-id">
                <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
                <input type="text" name="promocion" id="edit-promocion" placeholder="Promoción">

                <select id="edit-id_escuela" name="id_escuela">
                    <option value="">Selecciona un escuela</option>
                </select>

                <button type="submit" class="btn13">Actualizar</button>
            </form>
            <a href="#" id="cerrar1" class="modal__close2">&times;</a>
        </div>
        </div>

    </div>



    <script>
        $(document).ready(function() {

            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadCursos();
            loadEscuelas();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadCursos() {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'cursos',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, curso) {
                            var nombre = curso.nombre.toLowerCase();
                            var promocion = curso.promocion.toLowerCase();
                            var escuela = curso.escuela.nombre.toLowerCase();


                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                promocion.indexOf(searchString) == -1 &&
                                escuela.indexOf(searchString) == -1) {

                                return true; // Continue
                            }

                            tableRows += '<tr>';
                            tableRows += '<td>' + curso.nombre + '</td>';
                            tableRows += '<td>' + curso.promocion + '</td>';
                            tableRows += '<td>' + curso.escuela.nombre + '</td>';


                            tableRows += '<td>';
                            tableRows += '<a href="#asignaturas2"><button class="edit-curso" data-id="' + curso.id +
                                '" data-nombre="' + curso.nombre +
                                '" data-promocion="' + curso.promocion +
                                '" data-id_escuela="' + curso.id_escuela +

                                '">Editar</button></a>';

                            tableRows += '<button class="delete-curso" data-id="' + curso.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#cursos tbody').html(tableRows);
                    }
                });
            }


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR CURSOS
            function loadEscuelas() {
                // Obtener los cursos y agregar opciones al desplegable
                $.ajax({
                    url: 'escuelas',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="">Selecciona una escuela</option>';
                        $.each(data, function(i, escuela) {
                            options += '<option value="' + escuela.id + '">' + escuela.nombre +
                                '</option>';
                        });
                        $('#escuela, #edit-id_escuela, #select-filtro').html(options);
                    }
                });
            }

            //*Sirve para vaciar la informacion del modal cada vez que haces click en el boton *//
            document.querySelector('a[href="#asignaturas1"]').addEventListener('click', function(event) {
            // Obtén el formulario y establece los valores de los campos en vacío
            var formulario = document.getElementById("form-insert");
            formulario.reset();
            });
            




            $('#buscador').on('keyup', function() {
                loadCursos();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'cursos',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();
                        document.getElementById('cerrar').click();
                        // Recargar la lista de usuarios
                        loadCursos();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-curso', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar este curso?')) {
                    $.ajax({
                        url: 'cursos/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadCursos();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para editar los datos del CRUD al servidor con AJAX/JQUERY
            $(document).ready(function() {
                // asignar evento submit al formulario de edición
                $('#form-edit').on('submit', function(e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    var id = $('#edit-id').val();
                    $.ajax({
                        url: 'cursos/' + id,
                        type: 'PUT',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            // hide the edit form
                            $('#form-edit').hide();
                            // clear the form fields
                            $('#edit-nombre').val('');
                            $('#edit-promocion').val('');
                            $('#edit-id_escuela').val('');
                            document.getElementById('cerrar1').click();

                            // reload the user list
                            loadCursos();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editCurso(id, nombre, promocion, id_escuela) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-promocion').val(promocion);
                    $('#edit-id_escuela').val(id_escuela);


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-curso', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var promocion = $(this).data('promocion');
                    var id_escuela = $(this).data('id_escuela');

                    // llama a la funcion editUser 
                    editCurso(id, nombre, promocion, id_escuela);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

        // EXPORTAR
        const btnExportar = document.getElementById('btn-exportar');
    
        btnExportar.addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'expcur', true);
            xhr.responseType = 'blob';
            xhr.onload = () => {
                if (xhr.status === 200) {
                    const a = document.createElement('a');
                    a.href = window.URL.createObjectURL(xhr.response);
                    a.download = 'cursos.csv';
                    a.click();
                }
            };
            xhr.send();
        });
    
        // IMPORTAR
        const importForm = document.querySelector('#import-form');
        const importResults = document.querySelector('#import-results');
    

        importForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevenir que el formulario se envíe
    
            // Crear una instancia de FormData para enviar el archivo CSV
            const formData = new FormData(importForm);
    
            // Crear una instancia de XMLHttpRequest para enviar el formulario mediante AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'impcur', true);
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Mostrar los resultados en el elemento correspondiente
                        importResults.innerHTML = xhr.responseText;
                    } else {
                        // Mostrar un mensaje de error en caso de que la petición haya fallado
                        importResults.innerHTML = '<p>Error al importar el archivo.</p>';
                    }
                }
            };
            xhr.send(formData);
            loadCursos();
            loadEscuelas();
        });
        const form = document.querySelector('#form-insert');
    form.addEventListener('submit', (e) => {
        e.preventDefault(); // cancelar envío normal del formulario

        // Obtener los valores de los campos del formulario
        const nombre = form.querySelector('input[name="nombre"]').value.trim();
        const pr = form.querySelector('input[name="promocion"]').value.trim();
        const escuela = form.querySelector('select[name="id_escuela"]').value.trim();

        // Validar que los campos no estén vacíos
        let valid = true;
        if (nombre === '') {
            valid = false;
            const nomElement = document.getElementById('nombre');
            nomElement.textContent = 'Debes insertar el nombre del curso';
        }else {
            const nomElement = document.getElementById('nombre');
            nomElement.textContent = '';
        }
        if (pr === '') {
            valid = false;
            const prElement = document.getElementById('pr');
            prElement.textContent = 'Debes insertar una promoción válida';
        }else {
            const prElement = document.getElementById('pr');
            prElement.textContent = '';
        }if (escuela === '') {
            valid = false;
            const esElement = document.getElementById('es');
            esElement.textContent = 'Debes insertar un curso de la lista';
        }else {
            const esElement = document.getElementById('es');
            if (window.innerWidth < 768) {
                esElement.textContent = '';
            } else {
                esElement.textContent = 'ㅤ';
            }
        }

        });

        });
    </script>
</body>

</html>
