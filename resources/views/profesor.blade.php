@extends('layouts.layoutprofesor')

@section('titulo', 'Panel de Control | Profesor')

@section('contenido')

    <h1>AQUI VA LA INTEERFAZ DEL CALENDARIO CON FILTROS Y CRUD DE SUS ALUMNOS EN SU CLASE</h1>

    <form id="password-form" action="{{ route('passprofe.panel') }}" method="POST">
        @csrf

        <div>
            <label for="newpass">Nueva contraseña</label>
            <input type="password" id="newpass" name="newpass" required>
        </div>

        <div>
            <label for="confirmpass">Confirmar contraseña</label>
            <input type="password" id="confirmpass" name="confirmpass" required>
        </div>    

        <button type="submit">Cambiar contraseña</button>
    </form>

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
