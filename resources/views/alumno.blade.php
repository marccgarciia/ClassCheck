@extends('layouts.layoutalumno')

@section('titulo', 'Panel de Control | Alumno')

@section('contenido')

    <ul class="box-info">

        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="texto">
                <h3>55</h3>
                <p>Total de Faltas</p>
            </span>
        </li>

        <li>
            <i class='bx bx-library'></i>
            <span class="texto">
                <h3>254</h3>
                <p>Total Asignaturas</p>
            </span>
        </li>

    </ul>

    <h1>AQUI VA LA INTEERFAZ DEL CALENDARIO</h1>


    <form id="password-form" action="{{ route('passalumno.panel') }}" method="POST">
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
