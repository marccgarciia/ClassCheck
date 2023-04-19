@extends('layouts.layoutprofesor')

@section('titulo', 'Panel de Control | Profesor')

@section('contenido')

    <h1>AQUI VA LA INTEERFAZ DEL CALENDARIO CON FILTROS Y CRUD DE SUS ALUMNOS EN SU CLASE</h1>
    <h1>Bienvenido, {{ auth('profesor')->user()->nombre }}</h1>

    <form action="{{ route('passprofe.panel') }}" method="POST">
        @csrf
    
        <div>
            <label for="newpass">Nueva contraseña</label>
            <input type="password" id="newpass" name="newpass" required>
        </div>
    
        <button type="submit">Cambiar contraseña</button>
    </form>

    <form action="{{ route('logout.profesor') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
@endsection
