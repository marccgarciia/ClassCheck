<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">

    <div id="alumnos">
        <h2>Lista de Alumnos</h2>

        {{-- Filtro para filtrar por cursos --}}
        {{-- <select id="select-filtro">
            <option value="">Filtrar por curso</option>
        </select> --}}

        <table>
            <thead>
                
                <tr>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Email Padre</th>
                    <th>Curso</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <form action="alumnos" method="POST" id="form-insert">
            <h2>Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="apellido" placeholder="Apellido">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="password" placeholder="Password">
            <input type="text" name="email_padre" placeholder="Email Padre">
            {{-- <input type="text" name="estado" placeholder="Estado"> --}}
            <select id="curso" name="id_curso">
                <option value="">Selecciona un curso</option>
            </select>

            <button type="submit">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="alumnos" method="POST" id="form-edit" style="display:none;">
            <h2>Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <input type="text" name="apellido" id="edit-apellido" placeholder="Apellido">
            <input type="text" name="email" id="edit-email" placeholder="Email">
            <input type="text" name="password" id="edit-password" placeholder="Password">
            <input type="text" name="email_padre" id="edit-email_padre" placeholder="Email Padre">
            <input type="text" name="estado" id="edit-estado" placeholder="Estado">
            {{-- <input type="text" name="id_curso" id="edit-id_curso" placeholder="Id curso"> --}}
            <select id="edit-id_curso" name="id_curso">
                <option value="">Selecciona un curso</option>
            </select>

            <button type="submit">Actualizar</button>
        </form>
    </div>



    <script>
        $(document).ready(function() {

            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadAlumnos();
            loadCursos();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadAlumnos() {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'alumnos',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, alumno) {
                            var nombre = alumno.nombre.toLowerCase();
                            var apellido = alumno.apellido.toLowerCase();
                            var email = alumno.email.toLowerCase();
                            // var password = alumno.password.toLowerCase();
                            var email_padre = alumno.email_padre.toLowerCase();
                            var curso = alumno.curso.nombre.toLowerCase();
                            var estado = alumno.estado;


                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                apellido.indexOf(searchString) == -1 &&
                                email.indexOf(searchString) == -1 &&
                                curso.indexOf(searchString) == -1 &&
                                email_padre.indexOf(searchString) == -1 &&
                                // password.indexOf(searchString) == -1 &&

                                estado != searchString) {

                                return true; // Continue
                            }

                            tableRows += '<tr>';
                            tableRows += '<td>' + alumno.nombre + '</td>';
                            tableRows += '<td>' + alumno.apellido + '</td>';
                            tableRows += '<td>' + alumno.email + '</td>';
                            tableRows += '<td>' + alumno.password + '</td>';
                            tableRows += '<td>' + alumno.email_padre + '</td>';
                            tableRows += '<td>' + alumno.curso.nombre + '</td>';
                            

                            // Verificar el estado y cambiar el texto correspondiente
                            if (alumno.estado == 1) {
                                tableRows += '<td>Activado</td>';
                            } else {
                                tableRows += '<td>Desactivado</td>';
                            }

                            tableRows += '<td>';
                            tableRows += '<button class="edit-alumno" data-id="' + alumno.id +
                                '" data-nombre="' + alumno.nombre +
                                '" data-apellido="' + alumno.apellido +
                                '" data-email="' + alumno.email +
                                '" data-password="' + alumno.password +
                                '" data-email_padre="' + alumno.email_padre +
                                '" data-id_curso="' + alumno.id_curso +
                                '" data-estado="' + alumno.estado +

                                '">Editar</button>';

                            tableRows += '<button class="delete-alumno" data-id="' + alumno.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#alumnos tbody').html(tableRows);
                    }
                });
            }


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR CURSOS
            function loadCursos() {
                // Obtener los cursos y agregar opciones al desplegable
                $.ajax({
                    url: 'cursos',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="">Selecciona un curso</option>';
                        $.each(data, function(i, curso) {
                            options += '<option value="' + curso.id + '">' + curso.nombre +
                                '</option>';
                        });
                        $('#curso, #edit-id_curso, #select-filtro').html(options);
                    }
                });
            }



            $('#buscador').on('keyup', function() {
                loadAlumnos();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'alumnos',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();

                        // Recargar la lista de usuarios
                        loadAlumnos();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-alumno', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar este usuario?')) {
                    $.ajax({
                        url: 'alumnos/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadAlumnos();
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
                        url: 'alumnos/' + id,
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
                            $('#edit-password').val('');
                            $('#edit-email_padre').val('');
                            $('#edit-id_curso').val('');
                            $('#edit-estado').val('');

                            // reload the user list
                            loadAlumnos();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editAlumno(id, nombre, apellido, email, password, email_padre, id_curso, estado) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-apellido').val(apellido);
                    $('#edit-email').val(email);
                    $('#edit-password').val(password);
                    $('#edit-email_padre').val(email_padre);
                    $('#edit-id_curso').val(id_curso);
                    $('#edit-estado').val(estado);


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-alumno', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var apellido = $(this).data('apellido');
                    var email = $(this).data('email');
                    var password = $(this).data('password');
                    var email_padre = $(this).data('email_padre');
                    var id_curso = $(this).data('id_curso');
                    var estado = $(this).data('estado');

                    // llama a la funcion editUser 
                    editAlumno(id, nombre, apellido, email, password, email_padre, id_curso,
                        estado);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::




        });
    </script>
</body>

</html>
