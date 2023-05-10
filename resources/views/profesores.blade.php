<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
    <button id="btn-exportar" class="btn">Exportar CSV</button>

    <div class="importar">
        <form id="import-form" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv-file" required class="impt">
            <button type="submit" class="btn">Importar</button>
        </form>
    </div>

    <div id="profesores">

        <div id="import-results"></div>
        {{-- Filtro para filtrar por cursos --}}
        {{-- <select id="select-filtro">
            <option value="">Filtrar por curso</option>
        </select> --}}

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo Electrónico</th>
                    {{-- <th>Password</th> --}}
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <form action="profesores" method="POST" id="form-insert">
            <h2 class="text">Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="apellido" placeholder="Apellido">
            <input type="text" name="email" placeholder="Correo Electrónico">
            <input type="text" name="password" placeholder="Contraseña">

            <button type="submit" class="btn">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="profesores" method="POST" id="form-edit" style="display:none;">
            <h2 class="text">Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <input type="text" name="apellido" id="edit-apellido" placeholder="Apellido">
            <input type="text" name="email" id="edit-email" placeholder="Correo Electrónico">
            {{-- <input type="text" name="password" id="edit-password" placeholder="Contraseña"> --}}
            <input type="text" name="estado" id="edit-estado" placeholder="Estado">

            <button type="submit" class="btn">Actualizar</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {

            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadProfesores();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadProfesores() {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'profesores',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, profesor) {
                            var nombre = profesor.nombre.toLowerCase();
                            var apellido = profesor.apellido.toLowerCase();
                            var email = profesor.email.toLowerCase();
                            var estado = profesor.estado;


                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                apellido.indexOf(searchString) == -1 &&
                                email.indexOf(searchString) == -1 &&
                                estado != searchString) {

                                return true; // Continue
                            }

                            tableRows += '<tr>';
                            tableRows += '<td>' + profesor.nombre + '</td>';
                            tableRows += '<td>' + profesor.apellido + '</td>';
                            tableRows += '<td>' + profesor.email + '</td>';
                            // tableRows += '<td>' + profesor.password + '</td>';

                            // Verificar el estado y cambiar el texto correspondiente
                            if (profesor.estado == 1) {
                                tableRows += '<td>Activado</td>';
                            } else {
                                tableRows += '<td>Desactivado</td>';
                            }

                            tableRows += '<td>';
                            tableRows += '<button class="edit-profesor" data-id="' + profesor
                                .id +
                                '" data-nombre="' + profesor.nombre +
                                '" data-apellido="' + profesor.apellido +
                                '" data-email="' + profesor.email +
                                '" data-password="' + profesor.password +
                                '" data-estado="' + profesor.estado +

                                '">Editar</button>';

                            tableRows += '<button class="delete-profesor" data-id="' + profesor
                                .id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#profesores tbody').html(tableRows);
                    }
                });
            }




            $('#buscador').on('keyup', function() {
                loadProfesores();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'profesores',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();

                        // Recargar la lista de usuarios
                        loadProfesores();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-profesor', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar este profesor?')) {
                    $.ajax({
                        url: 'profesores/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadProfesores();
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
                        url: 'profesores/' + id,
                        type: 'PUT',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            // hide the edit form
                            $('#form-edit').hide();
                            // clear the form fields
                            $('#edit-nombre').val('');
                            $('#edit-apellido').val('');
                            $('#edit-email').val('');
                            // $('#edit-password').val('');
                            $('#edit-estado').val('');

                            // reload the user list
                            loadProfesores();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editProfesor(id, nombre, apellido, email, estado) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-apellido').val(apellido);
                    $('#edit-email').val(email);
                    // $('#edit-password').val(password);
                    $('#edit-estado').val(estado);


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-profesor', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var apellido = $(this).data('apellido');
                    var email = $(this).data('email');
                    // var password = $(this).data('password');
                    var estado = $(this).data('estado');

                    // llama a la funcion editUser 
                    editProfesor(id, nombre, apellido, email, estado);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // EXPORTAR
            const btnExportar = document.getElementById('btn-exportar');

            btnExportar.addEventListener('click', () => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'expprof', true);
                xhr.responseType = 'blob';
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const a = document.createElement('a');
                        a.href = window.URL.createObjectURL(xhr.response);
                        a.download = 'profesores.csv';
                        a.click();
                    }
                };
                xhr.send();
            });

            // IMPORTAR
            // Obtener el formulario y el elemento donde se mostrarán los resultados
            const importForm = document.querySelector('#import-form');
            const importResults = document.querySelector('#import-results');

            // Escuchar el evento "submit" del formulario
            importForm.addEventListener('submit', (event) => {
                event.preventDefault(); // Prevenir que el formulario se envíe

                // Crear una instancia de FormData para enviar el archivo CSV
                const formData = new FormData(importForm);

                // Crear una instancia de XMLHttpRequest para enviar el formulario mediante AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'impprof', true);
                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Mostrar los resultados en el elemento correspondiente
                            importResults.innerHTML = xhr.responseText;
                            loadProfesores()
                        } else {
                            // Mostrar un mensaje de error en caso de que la petición haya fallado
                            importResults.innerHTML = '<p>Error al importar el archivo.</p>';
                        }
                    }
                };
                xhr.send(formData);
            });



        });
    </script>
</body>

</html>
