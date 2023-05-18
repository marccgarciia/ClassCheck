<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <input type="text" name="buscador" id="buscador" placeholder="Buscador...">

    <div id="asignaturas">
        {{-- Filtro para filtrar por cursos --}}
        {{-- <select id="select-filtro">
            <option value="">Filtrar por curso</option>
        </select> --}}

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Profesor</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <ul id="pagination" class="pagination"></ul>

    <div>
        <form action="asignaturas" method="POST" id="form-insert">
            <h2 class="text">Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">

            <select id="curso" name="id_curso">
                <option value="">Selecciona un curso</option>
            </select>

            <select id="profesor" name="id_profesor">
                <option value="">Selecciona un profesor</option>
            </select>

            <button type="submit" class="btn">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="asignaturas" method="POST" id="form-edit" style="display:none;">
            <h2 class="text">Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">

            <select id="edit-id_curso" name="id_curso">
                <option value="">Selecciona un curso</option>
            </select>

            <select id="edit-id_profesor" name="id_profesor">
                <option value="">Selecciona un profesor</option>
            </select>

            <button type="submit" class="btn">Actualizar</button>
        </form>
    </div>



    <script>
        $(document).ready(function() {
            // BUSCADOR, DESCOEMNTAR CUANDO YA ESTÁ TODO ESTRUCTURADO
            // buscador.addEventListener("keyup", () => {
            // let filtro = buscador.value;
            //     if (!filtro) {
            //         loadAsignaturas('')
            //     } else {
            //         loadAsignaturas(filtro);
            //     }
            // })
            // Cargar usuarios al cargar la página con AJAX/JQUERY

            // Variables globales para mantener el estado de la paginación !!!
            var currentPage = 1;
            var lastPage = 1;

            loadAsignaturas();
            loadCursos();
            loadProfesores();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadAsignaturas(/*filtro*/) {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'asignaturas',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var tableRows = '';
                        var searchString = $('#buscador').val()
                            .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data, function(i, asignatura) {
                            var nombre = asignatura.nombre.toLowerCase();
                            var curso = asignatura.curso.nombre.toLowerCase();
                            var profesor = asignatura.profesor.nombre.toLowerCase();


                            // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                            if (searchString && nombre.indexOf(searchString) == -1 &&
                                curso.indexOf(searchString) == -1 &&
                                profesor.indexOf(searchString) == -1) {

                                return true; // Continue
                            }
                            console.log(asignatura)
                            tableRows += '<tr>';
                            tableRows += '<td>' + asignatura.nombre + '</td>';
                            tableRows += '<td>' + asignatura.curso.nombre + '</td>';
                            tableRows += '<td>' + asignatura.profesor.nombre + " " + asignatura.profesor.apellido + '</td>';
                            tableRows += '<td>';
                            tableRows += '<button class="edit-asignatura" data-id="' +
                                asignatura.id +
                                '" data-nombre="' + asignatura.nombre +
                                '" data-id_curso="' + asignatura.id_curso +
                                '" data-id_profesor="' + asignatura.id_profesor +

                                '">Editar</button>';

                            tableRows += '<button class="delete-asignatura" data-id="' +
                                asignatura.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#asignaturas tbody').html(tableRows);
                    }
                });
            }


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR CURSOS
            function loadCursos() {
                // Obtener los cursos y agregar opciones al desplegable
                $.ajax({
                    url: 'cursosload',
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


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR PROFESORES
            function loadProfesores() {
                // Obtener los cursos y agregar opciones al desplegable
                $.ajax({
                    url: 'profesores',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        var options = '<option value="">Selecciona un profesor</option>';
                        $.each(data, function(i, profesor) {
                            options += '<option value="' + profesor.id + '">' + profesor
                                .nombre +
                                '</option>';
                        });
                        $('#profesor, #edit-id_profesor, #select-filtro').html(options);
                    }
                });
            }


            $('#buscador').on('keyup', function() {
                loadAsignaturas();
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para enviar los datos del formulario al servidor con AJAX/JQUERY
            $('#form-insert').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this)
                    .serialize(); // cambiar a $(this) para serializar solo el formulario actual

                $.ajax({
                    url: 'asignaturas',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        // Limpiar el formulario
                        $('form')[0].reset();

                        // Recargar la lista de usuarios
                        loadAsignaturas();
                        actualizarContadores();

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para eliminar los datos del CRUD al servidor con AJAX/JQUERY
            $('body').on('click', '.delete-asignatura', function() {
                var checkId = $(this).data('id');

                if (confirm('¿Estás seguro de que quieres eliminar esta asignatura?')) {
                    $.ajax({
                        url: 'asignaturas/' + checkId,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(response) {
                            loadAsignaturas();
                            actualizarContadores();

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
                        url: 'asignaturas/' + id,
                        type: 'PUT',
                        dataType: 'json',
                        data: formData,
                        success: function(response) {
                            // hide the edit form
                            $('#form-edit').hide();
                            // clear the form fields
                            $('#edit-nombre').val('');
                            $('#edit-id_curso').val('');
                            $('#edit-id_profesor').val('');

                            // reload the user list
                            loadAsignaturas();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editProfesor(id, nombre, id_curso, id_profesor) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-id_curso').val(id_curso);
                    $('#edit-id_profesor').val(id_profesor);


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-asignatura', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var id_curso = $(this).data('id_curso');
                    var id_profesor = $(this).data('id_profesor');

                    // llama a la funcion editUser 
                    editProfesor(id, nombre, id_curso, id_profesor);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::


        });
    </script>
</body>

</html>
