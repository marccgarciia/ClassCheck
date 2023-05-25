<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignaturas</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="importar" id="aaa">
        <form id="import-form" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv-file" required>
            <button type="submit" class="btn" id="imp">Importar</button>

        </form>
        <div class="btn_panel">
            <button id="btn-exportar" class="btn">Exportar CSV</button>
        </div>
    </div>
    <div class="filtraje">
        <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
    </div>
    <div id="asignaturas">
        <div id="import-results"></div>
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
            <tbody id="asignaturas-tbody">
            </tbody>
        </table>
    </div>
    {{-- !!!!! PAGINACIÓN UL NO TOCAR --}}
    <ul id="pagination" class="pagination"></ul>

    <div>
    <a href="#asignaturas1"><button class="btn">Insertar</button></a>
        <div id="asignaturas1" class="modal">
            <div class="modal__content3">
                <form action="asignaturas" method="POST" id="form-insert">
                    <h2 class="text12">Formulario de Insertar</h2>
                    @csrf
                    <div class="nombre">
                        <input type="text" name="nombre" placeholder="Nombre">
                        <p id="nombre"></p>
                    </div>
                    <div class="cur">
                        <select id="curso" name="id_curso">
                            <option value="">Selecciona un curso</option>
                        </select>
                        <p id="cur"></p>
                    </div>
                    <div class="pr">
                        <select id="profesor" name="id_profesor">
                            <option value="">Selecciona un profesor</option>
                        </select>
                        <p id="pr"></p>
                    </div>
                    <button type="submit" class="btn12">Insertar</button>
                </form>
                <a href="#" id="cerrar" class="modal__close1">&times;</a>
            </div>
        </div>
    </div>

    <div>
        <div id="asignaturas2" class="modal2">
            <div class="modal__content4">
                <form action="asignaturas" method="POST" id="form-edit"
                    style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                    <h2 class="text13">Formulario de Editar</h2>
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
                    <button type="submit" class="btn13">Actualizar</button>
                </form>
                <a href="#" id="cerrar1" class="modal__close2">&times;</a>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // BUSCADOR, DESCOEMNTAR CUANDO YA ESTÁ TODO ESTRUCTURADO
            buscador.addEventListener("keyup", () => {
                let filtro = buscador.value;
                if (!filtro) {
                    loadAsignaturas('')
                } else {
                    loadAsignaturas(filtro);
                }
            })
            // Cargar usuarios al cargar la página con AJAX/JQUERY

            // Variables globales para mantener el estado de la paginación !!!
            var currentPage = 1;
            var lastPage = 1;

            loadAsignaturas();
            loadCursos();
            loadProfesores();

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadAsignaturas(filtro) {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'asignaturas',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        // Aquí voy a mandar el current page y el filtro
                        page: currentPage,
                        filtro: filtro
                    },
                    success: function(data) {
                    var tableRows = '';
                    $.each(data.data, function(i, asignatura) {
                            tableRows += '<tr>';
                            tableRows += '<td>' + asignatura.nombre + '</td>';
                            tableRows += '<td>' + asignatura.curso.nombre + '</td>';
                            tableRows += '<td>' + asignatura.profesor.nombre + " " + asignatura
                                .profesor.apellido + '</td>';
                            tableRows += '<td>';
                            tableRows +=
                                '<a href="#asignaturas2"><button class="edit-asignatura" data-id="' +
                                asignatura.id +
                                '" data-nombre="' + asignatura.nombre +
                                '" data-id_curso="' + asignatura.id_curso +
                                '" data-id_profesor="' + asignatura.id_profesor +

                                '">Editar</button></a>';

                            tableRows += '<button class="delete-asignatura" data-id="' +
                                asignatura.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#asignaturas-tbody').html(tableRows);
                        currentPage = data.current_page; // Actualiza el número de página actual
                        lastPage = data.last_page; // Actualiza el número de la última página
                        console.log("PAGINACION LOAD ASIGNATURAS")
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
                currentPage = 1;

                // Agrega botones numéricos para todas las páginas disponibles
                for (var i = 1; i <= lastPage; i++) {
                    pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' +
                        i + '</a></li>';
                }

                // Actualiza el contenido de la lista desordenada con los botones numéricos
                $('#pagination').html(pageButtons);

                // Control de eventos para los botones numéricos
                $('.page-link').click(function(event) {
                    event.preventDefault();
                    currentPage = $(this).data('page');
                    let filtro = buscador.value;
                    if (!filtro) {
                        loadAsignaturas('');
                    } else {
                        loadAsignaturas(filtro);
                    }
                });

                // Control de eventos para el botón de página anterior
                prevBtn.click(function(event) {
                    event.preventDefault();
                    if (currentPage > 1) {
                        currentPage--;
                        let filtro = buscador.value;
                        if (!filtro) {
                            loadAsignaturas('');
                        } else {
                            loadAsignaturas(filtro);
                        }
                    }
                });

                // Control de eventos para el botón de página siguiente
                nextBtn.click(function(event) {
                    event.preventDefault();
                    if (currentPage < lastPage) {
                        currentPage++;
                        let filtro = buscador.value;
                        if (!filtro) {
                            loadAsignaturas('');
                        } else {
                            loadAsignaturas(filtro);
                        }
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
                    url: 'profesoresload',
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

            //*Sirve para vaciar la informacion del modal cada vez que haces click en el boton *//
            document.querySelector('a[href="#asignaturas1"]').addEventListener('click', function(event) {
                // Obtén el formulario y establece los valores de los campos en vacío
                var formulario = document.getElementById("form-insert");
                formulario.reset();
            });


            // $('#buscador').on('keyup', function() {
            //     loadAsignaturas();
            // });

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
                        document.getElementById('cerrar').click();

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

            // Llamar a SweetAlert de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
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

                    // Llamar a SweetAlert de éxito después de eliminar
                    Swal.fire(
                        'Eliminada',
                        'La asignatura ha sido eliminada',
                        'success'
                    );
                    },
                    error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    }
                });
                }
            });
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
                            document.getElementById('cerrar1').click();


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

            // EXPORTAR
            const btnExportar = document.getElementById('btn-exportar');

            btnExportar.addEventListener('click', () => {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'expas', true);
                xhr.responseType = 'blob';
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const a = document.createElement('a');
                        a.href = window.URL.createObjectURL(xhr.response);
                        a.download = 'asignaturas.csv';
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
                xhr.open('POST', 'impas', true);
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
                loadAsignaturas();
                loadCursos();
                loadProfesores();
            });
            const form = document.querySelector('#form-insert');
            form.addEventListener('submit', (e) => {
                e.preventDefault(); // cancelar envío normal del formulario

                // Obtener los valores de los campos del formulario
                const nombre = form.querySelector('input[name="nombre"]').value.trim();
                const id_curso = form.querySelector('select[name="id_curso"]').value.trim();
                const pr = form.querySelector('select[name="id_profesor"]').value.trim();

                // Validar que los campos no estén vacíos
                let valid = true;
                if (nombre === '') {
                    valid = false;
                    const nomElement = document.getElementById('nombre');
                    nomElement.textContent = 'Debes insertar el nombre de la asignatura';
                } else {
                    const nomElement = document.getElementById('nombre');
                    nomElement.textContent = '';
                }
                if (id_curso === '') {
                    valid = false;
                    const curElement = document.getElementById('cur');
                    curElement.textContent = 'Debes insertar un curso de la lista';
                } else {
                    const curElement = document.getElementById('cur');
                    curElement.textContent = '';
                }
                if (pr === '') {
                    valid = false;
                    const prElement = document.getElementById('pr');
                    prElement.textContent = 'Debes insertar un profesor de la lista';
                } else {
                    const prElement = document.getElementById('pr');
                    prElement.textContent = '';
                }

                // Enviar el formulario a través de AJAX si todos los campos están completos

            });

        });
    </script>
</body>

</html>
