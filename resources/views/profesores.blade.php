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

    <div class="importar" id="ppp">
        <form id="import-form" enctype="multipart/form-data">
            @csrf
            <input type="file" name="csv-file" required class="impt" id="imp">

        </form>
        <div class="btn_panel">
            <button id="btn-exportar" class="btn">Exportar CSV</button>
            <button id="desactivar-seleccionados" type="button" class="btn">Desactivar</button>
            <button id="activar-seleccionados" type="button" class="btn">Activar</button>
        </div>
    </div>
    <div class="filtraje">
        <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
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
                    <th scope="col">Seleccionar</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="profesores-tbody">
            </tbody>
        </table>
    </div>
    {{-- !!!!! PAGINACIÓN UL NO TOCAR --}}
    <ul id="pagination" class="pagination"></ul>
    <div>


        <a href="#asignaturas1"><button class="btn">Insertar</button></a>
        <div id="asignaturas1" class="modal">
            <div class="modal__content1">
                <form action="asignaturas" method="POST" id="form-insert" style="display:block;">
                    <h2 class="text12">Formulario de Insertar</h2>
                    @csrf
                    <div>
                        <input type="text" name="nombre" placeholder="Nombre">
                        <p id="nombre"></p>
                    </div>
                    <div>
                        <input type="text" name="apellido" placeholder="Apellido">
                        <p id="ap"></p>
                    </div>
                    <div>
                        <input type="text" name="email" placeholder="Correo Electrónico">
                        <p id="email"></p>
                    </div>
                    <div class="pass2">
                        <input type="text" name="password" placeholder="Contraseña">
                        <p id="pass"></p>
                    </div>
                    <button type="submit" class="btn12">Insertar</button>
                </form>
                <a href="#" id="cerrar" class="modal__close1">&times;</a>
            </div>
        </div>

        <div>
            <!-- Agregar un nuevo formulario para la edición de usuarios -->
            <div id="asignaturas2" class="modal2">
                <div class="modal__content2">
                    <form action="asignaturas" method="POST" id="form-edit" style="display:block;">
                        <h2 class="text13">Formulario de Editar</h2>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="edit-id">
                        <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
                        <input type="text" name="apellido" id="edit-apellido" placeholder="Apellido">
                        <input type="text" name="email" id="edit-email" placeholder="Correo Electrónico">
                        {{-- <input type="text" name="password" id="edit-password" placeholder="Contraseña"> --}}
                        <input type="text" name="estado" id="edit-estado" placeholder="Estado">
                        <button type="submit" class="btn13">Actualizar</button>
                    </form>
                    <a href="#" id="cerrar1" class="modal__close2">&times;</a>
                </div>
            </div>


        </div>

        <script>
            $(document).ready(function() {

                buscador.addEventListener("keyup", () => {
                    let filtro = buscador.value;
                    if (!filtro) {
                        loadProfesores('')
                    } else {
                        loadProfesores(filtro);
                    }
                })

                // // Variables globales para mantener el estado de la paginación
                var currentPage = 1;
                var lastPage = 1;


                // Cargar usuarios al cargar la página con AJAX/JQUERY
                loadProfesores();

                // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
                // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
                function loadProfesores(filtro) {
                    // Obtener las categorías y agregar opciones al desplegable
                    $.ajax({
                        url: 'profesores',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            // Aquí voy a mandar el current page y el filtro
                            page: currentPage,
                            filtro: filtro
                        },
                        success: function(data) {
                            var tableRows = '';
                            // var searchString = $('#buscador').val()
                            //     .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                            $.each(data.data, function(i, profesor) {
                                // var nombre = profesor.nombre.toLowerCase();
                                // var apellido = profesor.apellido.toLowerCase();
                                // var email = profesor.email.toLowerCase();
                                // var estado = profesor.estado;


                                // // Si se ha escrito algo en el buscador y no se encuentra en ningún campo, omitir este registro
                                // if (searchString && nombre.indexOf(searchString) == -1 &&
                                //     apellido.indexOf(searchString) == -1 &&
                                //     email.indexOf(searchString) == -1 &&
                                //     estado != searchString) {

                                //     return true; // Continue
                                // }

                                tableRows += '<tr>';
                                tableRows += '<td>' + profesor.nombre + '</td>';
                                tableRows += '<td>' + profesor.apellido + '</td>';
                                tableRows += '<td>' + profesor.email + '</td>';
                                // tableRows += '<td>' + profesor.password + '</td>';
                                tableRows +=
                                    '<td><input type="checkbox" name="seleccionar" value="' +
                                    profesor.id + '"></td>';

                                // Verificar el estado y cambiar el texto correspondiente
                                if (profesor.estado == 1) {
                                    tableRows += '<td>Activado</td>';
                                } else {
                                    tableRows += '<td>Desactivado</td>';
                                }

                                tableRows += '<td>';
                                tableRows +=
                                    '<a href="#asignaturas2"><button class="edit-profesor" data-id="' +
                                    profesor
                                    .id +
                                    '" data-nombre="' + profesor.nombre +
                                    '" data-apellido="' + profesor.apellido +
                                    '" data-email="' + profesor.email +
                                    '" data-password="' + profesor.password +
                                    '" data-estado="' + profesor.estado +

                                    '">Editar</button></a>';

                                tableRows += '<button class="delete-profesor" data-id="' + profesor
                                    .id +
                                    '">Eliminar</button>';
                                tableRows += '</td>';
                                tableRows += '</tr>';
                            });
                            $('#profesores-tbody').html(tableRows);
                            currentPage = data.current_page; // Actualiza el número de página actual
                            lastPage = data.last_page; // Actualiza el número de la última página
                            console.log("PAGINACION LOAD PROFESORES")
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
                            loadProfesores('');
                        } else {
                            loadProfesores(filtro);
                        }
                    });

                    // Control de eventos para el botón de página anterior
                    prevBtn.click(function(event) {
                        event.preventDefault();
                        if (currentPage > 1) {
                            currentPage--;
                            let filtro = buscador.value;
                            if (!filtro) {
                                loadProfesores('');
                            } else {
                                loadProfesores(filtro);
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
                                loadProfesores('');
                            } else {
                                loadProfesores(filtro);
                            }
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
                //     loadProfesores();
                // });

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
                            document.getElementById('cerrar').click();

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
                                document.getElementById('cerrar1').click();

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
                const importForm = document.querySelector('#import-form');
                const importResults = document.querySelector('#import-results');


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
                    const apellido = form.querySelector('input[name="apellido"]').value.trim();
                    const email = form.querySelector('input[name="email"]').value.trim();
                    const password = form.querySelector('input[name="password"]').value.trim();

                    // Validar que los campos no estén vacíos
                    let valid = true;
                    if (nombre === '') {
                        valid = false;
                        const nomElement = document.getElementById('nombre');
                        nomElement.textContent = 'Debes insertar el nombre del profesor';
                    } else {
                        const nomElement = document.getElementById('nombre');
                        nomElement.textContent = '';
                    }
                    if (apellido === '') {
                        valid = false;
                        const apElement = document.getElementById('ap');
                        apElement.textContent = 'Debes insertar el apellido del profesor';
                    } else {
                        const apElement = document.getElementById('ap');
                        apElement.textContent = '';
                    }
                    if (email === '') {
                        valid = false;
                        const emailElement = document.getElementById('email');
                        emailElement.textContent = 'Debes insertar un email para el profesor';
                    } else if (!/\S+@\S+\.\S+/.test(email)) {
                        valid = false;
                        const emailElement = document.getElementById('email');
                        emailElement.textContent = 'El formato del correo electrónico no es válido';
                    } else if (nombre === '' || apellido === '') {
                        const emailElement = document.getElementById('email');
                        if (window.innerWidth < 768) {
                            emailElement.textContent = '';
                        } else {
                            emailElement.textContent = 'ㅤ';
                        }
                    } else {
                        const emailElement = document.getElementById('email');
                        emailElement.textContent = '';
                    }
                    if (password === '') {
                        valid = false;
                        const passElement = document.getElementById('pass');
                        passElement.textContent = 'Debes insertar una contraseña';
                    } else {
                        const passElement = document.getElementById('pass');
                        passElement.textContent = '';
                    }

                });

                // ACTIVAR / DESACTIVAR
                document.getElementById('desactivar-seleccionados').addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar el comportamiento predeterminado del botón

                    var checkboxes = document.querySelectorAll(
                        '#profesores-tbody input[name="seleccionar"]:checked');
                    var selectedProfes = Array.from(checkboxes).map(function(checkbox) {
                        return checkbox.value;
                        console.log(checkbox.value);
                    });

                    // Enviar los datos utilizando AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'desactivarp', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'));
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                // Manejar la respuesta del controlador si es necesario
                                console.log(xhr.responseText);
                                loadProfesores();
                            } else {
                                // Mostrar un mensaje de error en caso de que la petición haya fallado
                                xhr.responseText = '<p>Error al importar el archivo.</p>';
                                console.log(xhr.responseText);
                            }
                        }
                    };
                    xhr.send(JSON.stringify({
                        profesores: selectedProfes
                    }));
                });
                document.getElementById('activar-seleccionados').addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar el comportamiento predeterminado del botón

                    var checkboxes = document.querySelectorAll(
                        '#profesores-tbody input[name="seleccionar"]:checked');
                    var selectedProfes = Array.from(checkboxes).map(function(checkbox) {
                        return checkbox.value;
                        console.log(checkbox.value);
                    });

                    // Enviar los datos utilizando AJAX
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'activarp', true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content'));
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                // Manejar la respuesta del controlador si es necesario
                                console.log(xhr.responseText);
                                loadProfesores();
                            } else {
                                // Mostrar un mensaje de error en caso de que la petición haya fallado
                                xhr.responseText = '<p>Error al importar el archivo.</p>';
                                console.log(xhr.responseText);
                            }
                        }
                    };
                    xhr.send(JSON.stringify({
                        profesores: selectedProfes
                    }));
                });

            });
        </script>
</body>

</html>
