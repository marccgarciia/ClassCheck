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
            <tbody>
            </tbody>
        </table>
    </div>

    <div>
        <button class="btn" onclick="location.href='#asignaturas1'">Insertar</button>
        {{-- <a href="#asignaturas1"><button class="btn">Insertar</button></a> --}}
        <div id="asignaturas1" class="modal">
            <div class="modal__content1">
                <form action="cursos" method="POST" id="form-insert">
                    <h2 class="text12">Formulario de Insertar</h2>
                    @csrf
                    <input type="text" name="nombre" placeholder="Nombre">
                    <input type="text" name="promocion" placeholder="Promoción">

                    <select id="escuela" name="id_escuela">
                        <option value="">Selecciona un escuela</option>
                    </select>

                    <button type="submit" class="btn12">Insertar</button>
                </form>
                <a href="#" id="cerrar" class="modal__close1">&times;</a>
            </div>
        </div>
    </div>


    <div>
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
        <div id="asignaturas2" class="modal2">
        <div class="modal__content2">
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
        <style>
            #asignaturas1 {
                z-index: 999;
                visibility: hidden;
                opacity: 0;
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                /* background: rgba(0, 0, 0, 0.8);
                transition: all .4s; */
                backdrop-filter: blur(2px);
            }
    
            .text12{
                padding-top: 8px;
                color: #fff;
                font-size: 20px;
            }
    
            #asignaturas1:target {
                visibility: visible;
                opacity: 1;
            }
    
            .btn12 {
                background-color: var(--color-azuloscuro);
                color: var(--color-blanco);
                border-radius: 5px !important;
                padding: 3px 10px;
                text-align: center;
                margin: 3px;
            }
    
            .modal__content1 {
                border-radius: 20px;
                position: relative;
                width: 275px;
                height: 300px;
                background: #2B4D6D;
                padding: 1em 2em;
                }
    
            .modal__close1 {
                position: absolute;
                top: 10px;
                right: 15px;
                color: #fff;
                text-decoration: none;
                font-size: 20px;
            }
    
            /* separador */
    
            #asignaturas2 {
                z-index: 999;
                visibility: hidden;
                opacity: 0;
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                left: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                /* background: rgba(0, 0, 0, 0.8);
                transition: all .4s; */
                backdrop-filter: blur(2px);
            }
    
            .text13{
                padding-top: 8px;
                color: #fff;
                font-size: 20px;
            }
    
            #asignaturas2:target {
                visibility: visible;
                opacity: 1;
            }
    
            .btn13 {
                background-color: var(--color-azuloscuro);
                color: var(--color-blanco);
                border-radius: 5px !important;
                padding: 3px 10px;
                text-align: center;
                margin: 3px;
            }
    
            .modal__content2 {
                border-radius: 20px;
                position: relative;
                width: 275px;
                height: 300px;
                background: #2B4D6D;
                padding: 1em 2em;
                }
    
            .modal__close2 {
                position: absolute;
                top: 10px;
                right: 15px;
                color: #fff;
                text-decoration: none;
                font-size: 20px;
            }
    
            </style>
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

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // Función para cerrar modal 

            




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




        });
    </script>
</body>

</html>
