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

    <div id="cursos">
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
            <tbody id="cursos-tbody">
            </tbody>
        </table>
    </div>

    <ul id="pagination" class="pagination"></ul>

    {{-- <nav class="d-flex justify-content-center">
        <ul class="pagination bg-transparent">
          <li class="page-item" id="pagination-prev">
            <a class="page-link text-dark" href="#" aria-label="Anterior">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
          <li class="page-item" id="pagination-next">
            <a class="page-link text-dark" href="#" aria-label="Siguiente">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
      </nav>
    <div> --}}
        <form action="cursos" method="POST" id="form-insert">
            <h2 class="text">Formulario de Insertar</h2>
            @csrf
            <input type="text" name="nombre" placeholder="Nombre">
            <input type="text" name="promocion" placeholder="Promoción">

            <select id="escuela" name="id_escuela">
                <option value="">Selecciona un escuela</option>
            </select>

            <button type="submit" class="btn">Insertar</button>
        </form>
    </div>

    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <form action="cursos" method="POST" id="form-edit" style="display:none;">
            <h2 class="text">Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <input type="text" name="promocion" id="edit-promocion" placeholder="Promoción">

            <select id="edit-id_escuela" name="id_escuela">
                <option value="">Selecciona un escuela</option>
            </select>

            <button type="submit" class="btn">Actualizar</button>
        </form>
    </div>



    <script>
        $(document).ready(function() {

        // // Variables globales para mantener el estado de la paginación
        var currentPage = 1;
        var lastPage = 1;

        // Cargar cursos al cargar la página con AJAX/JQUERY
        loadEscuelas();
        loadCursos();
        function loadCursos() {
        $.ajax({
            url: 'cursos',
            type: 'GET',
            dataType: 'json',
            data: { page: currentPage }, // Envía el número de página actual al servidor
            success: function(data) {
            var tableRows = '';
            $.each(data.data, function(i, curso) { // Accede a los datos de la página actual
                tableRows += '<tr><td>' + curso.nombre + '</td><td>' + curso.promocion + '</td><td>' + curso.escuela.nombre + '</td><td>';
                tableRows += '<button class="edit-curso" data-id="' + curso.id +
                            '" data-nombre="' + curso.nombre +
                            '" data-promocion="' + curso.promocion +
                            '" data-id_escuela="' + curso.id_escuela +
                            '">Editar</button>';
                tableRows += '<button class="delete-curso" data-id="' + curso.id +
                            '">Eliminar</button>';
                tableRows += '</td>';
                tableRows += '</tr>';

                // ... Código para crear las filas de la tabla ...
            });
            $('#cursos-tbody').html(tableRows);

            currentPage = data.current_page; // Actualiza el número de página actual
            lastPage = data.last_page; // Actualiza el número de la última página
            console.log("PAGINACION LOAD CURSOS")
            console.log(currentPage);
             console.log(lastPage);
            console.log("-------");
            // Actualiza los controles de paginación
            updatePagination();
            }
        });
        }

        
        function updatePagination() {
            var prevBtn = $('#pagination-prev');
            var nextBtn = $('#pagination-next');
            var pageButtons = '';

            // Agrega botones numéricos para todas las páginas disponibles
            for (var i = 1; i <= lastPage; i++) {
                pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
            }

            // Actualiza el contenido de la lista desordenada con los botones numéricos
            $('#pagination').html(pageButtons);

            // Control de eventos para los botones numéricos
            $('.page-link').click(function() {
                currentPage = $(this).data('page');
                loadCursos();
            });

            // Control de eventos para el botón de página anterior
            prevBtn.click(function() {
                if (currentPage > 1) {
                currentPage--;
                loadCursos();
                }
            });

            // Control de eventos para el botón de página siguiente
            nextBtn.click(function() {
                if (currentPage < lastPage) {
                currentPage++;
                loadCursos();
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



            // Agrega un evento keyup al input del buscador
            var buscadorFunction = function() {
                var searchTerm = $(this).val().toLowerCase(); // Obtiene el término de búsqueda y lo convierte en minúsculas

                // Hace una llamada AJAX para obtener los resultados filtrados
                $.ajax({
                    url: 'cursosfiltro',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                    search: searchTerm // Envía el término de búsqueda al servidor
                    },
                    success: function(data) {
                    var tableRows = '';
                    for (let i = 0; i < data.data.length; i++) {
                        const curso = data.data[i];
                        console.log(curso);
                        tableRows += '<tr><td>' + curso.nombre + '</td><td>' + curso.promocion + '</td><td>' + curso.escuela.nombre + '</td><td>';
                        tableRows += '<button class="edit-curso" data-id="' + curso.id +
                        '" data-nombre="' + curso.nombre +
                        '" data-promocion="' + curso.promocion +
                        '" data-id_escuela="' + curso.id_escuela +
                        '">Editar</button>';
                        tableRows += '<button class="delete-curso" data-id="' + curso.id +
                        '">Eliminar</button>';
                        tableRows += '</td>';
                        tableRows += '</tr>';
                    }
                    $('#cursos-tbody').html(tableRows); // Actualiza la tabla con los datos filtrados
                    currentPage = data.current_page; // Actualiza el número de página actual
                    lastPage = data.last_page; // Actualiza el número de la última página
                    console.log("PAGINACION BUSCADOR")
                    console.log(currentPage);
                    console.log(lastPage);
                    console.log("-------");
                    // Actualiza los controles de paginación
                    var prevBtn = $('#pagination-prev');
                var nextBtn = $('#pagination-next');
                var pageButtons = '';

                // Agrega botones numéricos para todas las páginas disponibles
                for (var i = 1; i <= lastPage; i++) {
                    pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                // Actualiza el contenido de la lista desordenada con los botones numéricos
                $('#pagination').html(pageButtons);

                // Control de eventos para los botones numéricos
                $('.page-link').click(function() {
                    currentPage = $(this).data('page');
                    $('#buscador').on('keyup', buscadorFunction);
                });

                // Control de eventos para el botón de página anterior
                prevBtn.click(function() {
                    if (currentPage > 1) {
                        currentPage--;
                        $('#buscador').on('keyup', buscadorFunction);
                    }
                });

                // Control de eventos para el botón de página siguiente
                nextBtn.click(function() {
                    if (currentPage < lastPage) {
                        currentPage++;
                        $('#buscador').on('keyup', buscadorFunction);
                    }
                });
                    }
                });
            };

            // para llamar la función
            $('#buscador').on('keyup', buscadorFunction);

            function updatePagination2() {
                var prevBtn = $('#pagination-prev');
                var nextBtn = $('#pagination-next');
                var pageButtons = '';

                // Agrega botones numéricos para todas las páginas disponibles
                for (var i = 1; i <= lastPage; i++) {
                    pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                // Actualiza el contenido de la lista desordenada con los botones numéricos
                $('#pagination').html(pageButtons);

                // Control de eventos para los botones numéricos
                $('.page-link').click(function() {
                    currentPage = $(this).data('page');
                    $('#buscador').on('keyup', buscadorFunction);
                });

                // Control de eventos para el botón de página anterior
                prevBtn.click(function() {
                    if (currentPage > 1) {
                        currentPage--;
                        $('#buscador').on('keyup', buscadorFunction);
                    }
                });

                // Control de eventos para el botón de página siguiente
                nextBtn.click(function() {
                    if (currentPage < lastPage) {
                        currentPage++;
                        $('#buscador').on('keyup', buscadorFunction);
                    }
                });
            }

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

                        // Recargar la lista de usuarios
                        loadCursos();
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




        });
    </script>
</body>

</html>
