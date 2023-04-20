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
    <h1>Bienvenido, {{ auth('alumno')->user()->nombre }}</h1>
    <h1>Tu curso es, {{ auth('alumno')->user()->curso->nombre }}</h1>

    <form action="{{ route('passalumno.panel') }}" method="POST">
        @csrf
    
        <div>
            <label for="newpass">Nueva contraseña</label>
            <input type="password" id="newpass" name="newpass" required>
        </div>
    
        <button type="submit">Cambiar contraseña</button>
    </form>

    
    <form action="{{ route('procesologoutalumno') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
