<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <div class="importar">
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
    <div id="cursos">
    <div id="import-results"></div>

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
            <form action="cursos" method="POST" id="form-edit" style="display:block;">
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
        loadEscuelas();
        loadCursos();
        // // Variables globales para mantener el estado de la paginación
        var currentPage = 1;
        var lastPage = 1;

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

        function editCurso(id, nombre, promocion, id_escuela) {
            // // set the form values
            $('#edit-id').val(id);
            $('#edit-nombre').val(nombre);
            $('#edit-promocion').val(promocion);
            $('#edit-id_escuela').val(id_escuela);
            // // mostrar el form de editar
            $('#form-edit').show();
        }

        // FUNCION QUE AL CLICAR RECOGE LOS DATOS ENVIADOS Y ACTIVA LA FUNCION DE ARRIBA PARA ENVIAR LOS DATOS AL SERVIDOR
        $('body').on('click', '.edit-curso', function() {
                    var id = $(this).data('id');
                    var nombre = $(this).data('nombre');
                    var promocion = $(this).data('promocion');
                    var id_escuela = $(this).data('id_escuela');

                    // // llama a la funcion editUser 
                    editCurso(id, nombre, promocion, id_escuela);
        });

        function loadCursos(filtro) {
        $.ajax({
            url: 'cursos',
            type: 'GET',
            dataType: 'json',
            data: { 
                page: currentPage,
                filtro: filtro
            }, // Envía el número de página actual al servidor
            success: function(data) {
            var tableRows = '';
            console.log(data);
            $.each(data.data, function(i, curso) { // Accede a los datos de la página actual
                tableRows += '<tr><td>' + curso.nombre + '</td><td>' + curso.promocion + '</td><td>' + curso.escuela.nombre + '</td><td>';
                    tableRows += '<a href="#asignaturas2"><button class="edit-curso" data-id="' + 
                        curso.id +
                        '" data-nombre="' + curso.nombre +
                        '" data-promocion="' + curso.promocion +
                        '" data-id_escuela="' + curso.id_escuela +

                        '">Editar</button></a>';

                tableRows += '<button onclick="eliminarCurso('+ curso.id +')" class="delete-curso" data-id="' + curso.id +
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
        
        function eliminarCurso(id) {
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
            var checkId = id;

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
                
                // Llamar a SweetAlert de éxito después de eliminar
                Swal.fire(
                    'Eliminado',
                    'El curso ha sido eliminado',
                    'success'
                );
                },
                error: function(xhr, status, error) {
                console.log(xhr.responseText);
                }
            });
            }
        });
        };

            
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
            $('.page-link').click(function(event) {
                event.preventDefault();
                currentPage = $(this).data('page');
                let filtro = buscador.value;
                if (!filtro) {
                loadCursos('');
                } else {
                loadCursos(filtro);
                }
            });

            // Control de eventos para el botón de página anterior
            prevBtn.click(function(event) {
                event.preventDefault();
                if (currentPage > 1) {
                currentPage--;
                let filtro = buscador.value;
                if (!filtro) {
                    loadCursos('');
                } else {
                    loadCursos(filtro);
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
                    loadCursos('');
                } else {
                    loadCursos(filtro);
                }
                }
            });
        }
        $(document).ready(function() {

        buscador.addEventListener("keyup", () => {
            let filtro = buscador.value;
                if (!filtro) {
                    loadCursos('')
                } else {
                    loadCursos(filtro);
                }
            })



            // $('#buscador').on('keyup', function() {
            //     loadCursos();
            // });

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
                        loadEscuelas();
                        loadCursos();
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
            esElement.textContent = '';
        }

        });

        });
    </script>
</body>



</html>
