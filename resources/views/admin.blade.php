@extends('layouts.layoutadmin')

@section('titulo', 'Panel de Control | Administrador')

@section('contenido')

    <ul class="box-info">

        <li>
            <i class='bx bxs-calendar-check'></i>
            <span class="texto">
                <h3>55</h3>
                <p>Cursos</p>
            </span>
        </li>

        <li>
            <i class='bx bxs-group'></i>
            <span class="texto">
                <h3>2834</h3>
                <p>Alumnos</p>
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

    <h1>AQUI VAN LOS CRUDS SEGUN LA PESTAÑA SELECCIONADA</h1>

@endsection