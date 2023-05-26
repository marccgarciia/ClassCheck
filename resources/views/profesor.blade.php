@extends('layouts.layoutprofesor')

@section('titulo', 'Panel de Control | Profesor')

@section('contenido')
    <script>
        // espera a que el documento esté listo antes de agregar el controlador de eventos
        $(document).ready(function() {
            // agrega un controlador de eventos para los clics en los enlaces de la barra lateral
            $('#sidebar .side-menu.top a').click(function(event) {
                // previene el comportamiento predeterminado del enlace (navegar a una nueva página)
                event.preventDefault();

                // borra el contenido anterior del contenedor principal
                $('#contenedor-contenido').empty();

                // obtiene la URL del archivo blade asociado con el enlace
                var url = $(this).attr('href');

                // envía una solicitud AJAX para obtener el contenido del archivo blade
                $.get(url, function(data) {
                    // actualiza el contenido del contenedor principal con la respuesta de la solicitud
                    $('#contenedor-contenido').html(data);
                });
            });

            // obtiene la URL del archivo blade asociado con la primera etiqueta li que tenga la clase "active"
            var activeLi = $('#sidebar .side-menu.top li.active:first');
            if (activeLi.length > 0) {
                var url = activeLi.find('a').attr('href');

                // envía una solicitud AJAX para obtener el contenido del archivo blade
                $.get(url, function(data) {
                    // actualiza el contenido del contenedor principal con la respuesta de la solicitud
                    $('#contenedor-contenido').html(data);
                });
            }
        });
    </script>

    <script>
        const form = document.getElementById('password-form');
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Evita que el formulario se envíe automáticamente

            const newPass = document.getElementById('newpass').value;
            const confirmPass = document.getElementById('confirmpass').value;

            if (newPass !== confirmPass) {
                alert('La confirmación de contraseña no coincide');
                return;
            }

            form.submit(); // Si la validación es correcta, envía el formulario
        });
    </script>

@endsection
