<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
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
    <button id="desactivar-seleccionados" type="button" class="btn">Desactivar</button>
    <button id="activar-seleccionados" type="button" class="btn">Activar</button>
</div>
    </div>
    <div class="filtraje">
        <input type="text" name="buscador" id="buscador" placeholder="Buscador...">
    </div>
    <div id="alumnos">

        <div id="import-results"></div>

        <table class="table">
            <thead>

                <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Correo Electrónico</th>
                    {{-- <th scope="col">Password</th> --}}
                    <th scope="col">Contacto Padres</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Seleccionar</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody id="alumnos-tbody">
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
            <div class="nom">
            <input type="text" name="nombre" placeholder="Nombre">
            <p id="nom"></p>
            </div>
            <div class="ap">
            <input type="text" name="apellido" placeholder="Apellidos">
            <p id="ap"></p>
            </div>
            <div class="email">
            <input type="text" name="email" placeholder="Correo Electrónico">
            <p id="email"></p>
            </div>
            <div class="pass">
            <input type="text" name="password" placeholder="Contraseña">
            <p id="pass"></p>
            </div>
            <div class="pad">
            <input type="text" name="email_padre" placeholder="Contacto Padres">
            <p id="email_p"></p>
            </div>
            
            {{-- <input type="text" name="estado" placeholder="Estado"> --}}
            <div class="curso">
            <select id="curso" name="id_curso">
                <option value="">Selecciona un curso</option>
            </select>
            <p id="id_curso"></p>
            </div>
            <p></p>
                <button type="submit" class="btn12">Insertar</button>
            </form>
            <a href="#" id="cerrar" class="modal__close1">&times;</a>
        </div>
        </div>
    </div>

    <div>
        <div id="asignaturas2" class="modal2">
        <div class="modal__content2">
        <!-- Agregar un nuevo formulario para la edición de usuarios -->
            <form action="alumnos" method="POST" id="form-edit" style="display:block;">
                <h2 class="text13">Formulario de Editar</h2>
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="nombre" id="edit-nombre" placeholder="Nombre">
            <p id="nom-p"></p>
            <input type="text" name="apellido" id="edit-apellido" placeholder="Apellido">
            <p id="ap-p"></p>
            <input type="text" name="email" id="edit-email" placeholder="Correo Electrónico">
            <p id="email-p"></p>
            {{-- <input type="text" name="password" id="edit-password" placeholder="Contraseña"> --}}
            <input type="text" name="email_padre" id="edit-email_padre" placeholder="Contacto Padres">
            <p id="email_p-p"></p>
            <select id="edit-estado" name="estado">
                <option value="Desactivado">Desactivado</option>
                <option value="Activado">Activado</option>
            </select>
            <p id="es-p"></p>
            <select id="edit-id_curso" name="id_curso">
                
            </select>
            <p id="id_curso-p"></p>
            <p></p>
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
                    loadAlumnos('')
                } else {
                    loadAlumnos(filtro);
                }
            })

             // // Variables globales para mantener el estado de la paginación
            var currentPage = 1;
            var lastPage = 1;


            // Cargar usuarios al cargar la página con AJAX/JQUERY
            loadAlumnos();
            loadCursos();



            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // FUNCIÓN PARA CARGAR USUARIOS CON AJAX/JQUERY Y BUSCAR SI ES NECESARIO
            function loadAlumnos(filtro) {
                // Obtener las categorías y agregar opciones al desplegable
                $.ajax({
                    url: 'alumnos',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        // Aquí voy a mandar el current page y el filtro
                        page: currentPage,
                        filtro: filtro
                    },
                    success: function(data) {
                        var tableRows = '';
                        // BUSCADOR MARC COMENTADO
                        // var searchString = $('#buscador').val()
                        //     .toLowerCase(); // Obtener el texto del buscador y pasarlo a minúsculas
                        $.each(data.data, function(i, alumno) {
                            console.log(filtro);

                            tableRows += '<tr>';
                            tableRows += '<td>' + alumno.nombre + '</td>';
                            tableRows += '<td>' + alumno.apellido + '</td>';
                            tableRows += '<td>' + alumno.email + '</td>';
                            // tableRows += '<td>' + alumno.password + '</td>';
                            tableRows += '<td>' + alumno.email_padre + '</td>';
                            tableRows += '<td>' + alumno.curso.nombre + '</td>';
                            tableRows +=
                                '<td><input type="checkbox" name="seleccionar" value="' +
                                alumno.id + '"></td>';


                            // Verificar el estado y cambiar el texto correspondiente
                            if (alumno.estado == 1) {
                                tableRows += '<td>Activado</td>';
                            } else {
                                tableRows += '<td>Desactivado</td>';
                            }

                            tableRows += '<td>';
                            tableRows += '<a href="#asignaturas2"><button class="edit-alumno" data-id="' + alumno.id +
                                '" data-nombre="' + alumno.nombre +
                                '" data-apellido="' + alumno.apellido +
                                '" data-email="' + alumno.email +
                                '" data-password="' + alumno.password +
                                '" data-email_padre="' + alumno.email_padre +
                                '" data-id_curso="' + alumno.id_curso +
                                '" data-estado="' + alumno.estado +

                                '">Editar</button></a>';

                            tableRows += '<button class="delete-alumno" data-id="' + alumno.id +
                                '">Eliminar</button>';
                            tableRows += '</td>';
                            tableRows += '</tr>';
                        });
                        $('#alumnos-tbody').html(tableRows);
                        currentPage = data.current_page; // Actualiza el número de página actual
                        lastPage = data.last_page; // Actualiza el número de la última página
                        console.log("PAGINACION LOAD ALUMNOS")
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
                    pageButtons += '<li class="page-item"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                // Actualiza el contenido de la lista desordenada con los botones numéricos
                $('#pagination').html(pageButtons);

                // Control de eventos para los botones numéricos
                $('.page-link').click(function(event) {
                    event.preventDefault();
                    currentPage = $(this).data('page');
                    let filtro = buscador.value;
                    if (!filtro) {
                    loadAlumnos('');
                    } else {
                    loadAlumnos(filtro);
                    }
                });

                // Control de eventos para el botón de página anterior
                prevBtn.click(function(event) {
                    event.preventDefault();
                    if (currentPage > 1) {
                    currentPage--;
                    let filtro = buscador.value;
                    if (!filtro) {
                        loadAlumnos('');
                    } else {
                        loadAlumnos(filtro);
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
                        loadAlumnos('');
                    } else {
                        loadAlumnos(filtro);
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

            //*Sirve para vaciar la informacion del modal cada vez que haces click en el boton *//
            document.querySelector('a[href="#asignaturas1"]').addEventListener('click', function(event) {
            // Obtén el formulario y establece los valores de los campos en vacío
            var formulario = document.getElementById("form-insert");
            formulario.reset();
            });


            // $('#buscador').on('keyup', function() {
            //     loadAlumnos();
            // });

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
                        document.getElementById('cerrar').click();

                        // Recargar la lista de usuarios
                        loadAlumnos();
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
            $('body').on('click', '.delete-alumno', function() {
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
                    url: 'alumnos/' + checkId,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                    '_token': $('input[name=_token]').val()
                    },
                    success: function(response) {
                    loadAlumnos();
                    actualizarContadores();

                    // Llamar a SweetAlert de éxito después de eliminar
                    Swal.fire(
                        'Eliminado',
                        'El usuario ha sido eliminado',
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
                            // $('#edit-password').val('');
                            $('#edit-email_padre').val('');
                            $('#edit-id_curso').val('');
                            $('#edit-estado').val('');
                            document.getElementById('cerrar1').click();

                            // reload the user list
                            loadAlumnos();
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });

                function editAlumno(id, nombre, apellido, email, email_padre, id_curso, estado) {
                    // set the form values
                    $('#edit-id').val(id);
                    $('#edit-nombre').val(nombre);
                    $('#edit-apellido').val(apellido);
                    $('#edit-email').val(email);
                    // $('#edit-password').val(password);
                    $('#edit-email_padre').val(email_padre);
                    $('#edit-id_curso').val(id_curso);
                    if (estado === false) {
                        $('#edit-estado').val("Desactivado");
                    }if (estado === true) {
                        $('#edit-estado').val("Activado");
                    }


                    // mostrar el form de editar
                    $('#form-edit').show();
                }

                // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
                $('body').on('click', '.edit-alumno', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var apellido = $(this).data('apellido');
                    var email = $(this).data('email');
                    // var password = $(this).data('password');
                    var email_padre = $(this).data('email_padre');
                    var id_curso = $(this).data('id_curso');
                    var estado = $(this).data('estado');


                    // llama a la funcion editUser 
                    editAlumno(id, nombre, apellido, email, email_padre, id_curso, estado);
                });
            });


            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            // ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::




        
        // });

        // EXPORTAR
        const btnExportar = document.getElementById('btn-exportar');

        btnExportar.addEventListener('click', () => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'expalu', true);
            xhr.responseType = 'blob';
            xhr.onload = () => {
                if (xhr.status === 200) {
                    const a = document.createElement('a');
                    a.href = window.URL.createObjectURL(xhr.response);
                    a.download = 'alumnos.csv';
                    a.click();
                }
            };
            xhr.send();
        });

        // IMPORTAR
        // Obtener el formulario y el elemento donde se mostrarán los resultados
        const importForm = document.querySelector('#import-form');
        const importResults = document.querySelector('#import-results');

        // // Escuchar el evento "submit" del formulario
        importForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevenir que el formulario se envíe

        //     // Crear una instancia de FormData para enviar el archivo CSV
            const formData = new FormData(importForm);

        //     // Crear una instancia de XMLHttpRequest para enviar el formulario mediante AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'impalu', true);
            xhr.onreadystatechange = () => {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        // Mostrar los resultados en el elemento correspondiente
                        importResults.innerHTML = xhr.responseText;
                        loadAlumnos();
                    } else {
                        // Mostrar un mensaje de error en caso de que la petición haya fallado
                        importResults.innerHTML = '<p>Error al importar el archivo.</p>';
                    }
                }
            };
            xhr.send(formData);
        });

    const form = document.querySelector('#form-insert');
    form.addEventListener('submit', (e) => {
        e.preventDefault(); // cancelar envío normal del formulario

        // Obtener los valores de los campos del formulario
        const nombre = form.querySelector('input[name="nombre"]').value.trim();
        const apellido = form.querySelector('input[name="apellido"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const password = form.querySelector('input[name="password"]').value.trim();
        const email_padre = form.querySelector('input[name="email_padre"]').value.trim();
        const id_curso = form.querySelector('select[name="id_curso"]').value.trim();

        // Validar que los campos no estén vacíos
        let valid = true;
        if (nombre === '') {
            valid = false;
            const nomElement = document.getElementById('nom');
            nomElement.textContent = 'Debes insertar el nombre del alumno';
        }else {
            const nomElement = document.getElementById('nom');
            nomElement.textContent = '';
        }
        if (apellido === '') {
            valid = false;
            const apElement = document.getElementById('ap');
            apElement.textContent = 'Debes insertar el apellido del alumno';
        }else {
            const apElement = document.getElementById('ap');
            apElement.textContent = '';
        }
        if (email === '') {
            valid = false;
            const emailElement = document.getElementById('email');
            emailElement.textContent = 'Debes insertar un email para el alumno';
        }else if (!/\S+@\S+\.\S+/.test(email)) {
            valid = false;
            const emailElement = document.getElementById('email');
            emailElement.textContent = 'El formato del correo electrónico no es válido';
        }else if (nombre === '' || apellido === '') {
            const emailElement = document.getElementById('email');
            emailElement.textContent = '';
        }else {
            const emailElement = document.getElementById('email');
            emailElement.textContent = '';
        }
        if (password === '') {
            valid = false;
            const passElement = document.getElementById('pass');
            passElement.textContent = 'Debes insertar una contraseña';
        }else {
            const passElement = document.getElementById('pass');
            passElement.textContent = '';
        }
        if (email_padre === '') {
            valid = false;
            const padElement = document.getElementById('email_p');
            padElement.textContent = 'Debes insertar el email del padre/madre o tutor legal';
        }else if (!/\S+@\S+\.\S+/.test(email_padre)) {
            valid = false;
            const padElement = document.getElementById('email_p');
            padElement.textContent = 'El formato del correo electrónico no es válido';
        }
        else {
            const padElement = document.getElementById('email_p');
            padElement.textContent = '';
        }
        if (id_curso === '') {
            valid = false;
            const curElement = document.getElementById('id_curso');
            curElement.textContent = 'Debes insertar un curso de la lista';
        }else {
            const curElement = document.getElementById('id_curso');
            curElement.textContent = '';
        }

            
        });

        const formE = document.querySelector('#form-edit');
    formE.addEventListener('submit', (e) => {
        e.preventDefault(); // cancelar envío normal del formulario

        // Obtener los valores de los campos del formulario
        const nombre = formE.querySelector('input[name="nombre"]').value.trim();
        const apellido = formE.querySelector('input[name="apellido"]').value.trim();
        const email = formE.querySelector('input[name="email"]').value.trim();
        const email_padre = formE.querySelector('input[name="email_padre"]').value.trim();
        const estado = formE.querySelector('select[name="estado"]').value.trim();
        const id_curso = formE.querySelector('select[name="id_curso"]').value.trim();

        // Validar que los campos no estén vacíos
        let valid = true;
        if (nombre === '') {
            valid = false;
            const nomElement = document.getElementById('nom-p');
            nomElement.textContent = 'Debes insertar el nombre del alumno';
        }else {
            const nomElement = document.getElementById('nom-p');
            nomElement.textContent = '';
        }
        if (apellido === '') {
            valid = false;
            const apElement = document.getElementById('ap-p');
            apElement.textContent = 'Debes insertar el apellido del alumno';
        }else {
            const apElement = document.getElementById('ap-p');
            apElement.textContent = '';
        }
        if (email === '') {
            valid = false;
            const emailElement = document.getElementById('email-p');
            emailElement.textContent = 'Debes insertar un email para el alumno';
        }else if (!/\S+@\S+\.\S+/.test(email)) {
            valid = false;
            const emailElement = document.getElementById('email-p');
            emailElement.textContent = 'El formato del correo electrónico no es válido';
        }else if (nombre === '' || apellido === '') {
            const emailElement = document.getElementById('email-p');
            emailElement.textContent = '';
        }else {
            const emailElement = document.getElementById('email-p');
            emailElement.textContent = '';
        }
        if (estado === '') {
            valid = false;
            const esElement = document.getElementById('es-p');
            esElement.textContent = 'Debes insertar una contraseña';
        }else {
            const esElement = document.getElementById('es-p');
            esElement.textContent = '';
        }
        if (email_padre === '') {
            valid = false;
            const padElement = document.getElementById('email_p-p');
            padElement.textContent = 'Debes insertar el email del padre/madre o tutor legal';
        }else if (!/\S+@\S+\.\S+/.test(email_padre)) {
            valid = false;
            const padElement = document.getElementById('email_p-p');
            padElement.textContent = 'El formato del correo electrónico no es válido';
        }
        else {
            const padElement = document.getElementById('email_p-p');
            padElement.textContent = '';
        }
        if (id_curso === '') {
            valid = false;
            const curElement = document.getElementById('id_curso-p');
            curElement.textContent = 'Debes insertar un curso de la lista';
        }else {
            const curElement = document.getElementById('id_curso-p');
            curElement.textContent = '';
        }


        });
        // ACTIVAR / DESACTIVAR
        document.getElementById('desactivar-seleccionados').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del botón

        var checkboxes = document.querySelectorAll('#alumnos-tbody input[name="seleccionar"]:checked');
        var selectedAlumnos = Array.from(checkboxes).map(function(checkbox) {
            return checkbox.value;
            console.log(checkbox.value);
        });

        // Enviar los datos utilizando AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'desactivar', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Manejar la respuesta del controlador si es necesario
                    console.log(xhr.responseText);
                    loadAlumnos();
                } else {
                    // Mostrar un mensaje de error en caso de que la petición haya fallado
                    xhr.responseText = '<p>Error al importar el archivo.</p>';
                    console.log(xhr.responseText);
                }
            }
        };
        xhr.send(JSON.stringify({ alumnos: selectedAlumnos }));
    });
    document.getElementById('activar-seleccionados').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar el comportamiento predeterminado del botón

        var checkboxes = document.querySelectorAll('#alumnos-tbody input[name="seleccionar"]:checked');
        var selectedAlumnos = Array.from(checkboxes).map(function(checkbox) {
            return checkbox.value;
            console.log(checkbox.value);
        });

        // Enviar los datos utilizando AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'activar', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Manejar la respuesta del controlador si es necesario
                    console.log(xhr.responseText);
                    loadAlumnos();
                } else {
                    // Mostrar un mensaje de error en caso de que la petición haya fallado
                    xhr.responseText = '<p>Error al importar el archivo.</p>';
                    console.log(xhr.responseText);
                }
            }
        };
        xhr.send(JSON.stringify({ alumnos: selectedAlumnos }));
    });


        });
    </script>


</body>

</html>
