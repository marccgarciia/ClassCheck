<div class="divdatos">
    <h1 id="tituloscan"> DATOS PERSONALES</h1>
    <h1><b>Nombre:</b> {{ auth('alumno')->user()->nombre }}</h1>
    <h1><b>Correo Electrónico:</b> {{ auth('alumno')->user()->email }}</h1>
    <h1><b>Curso:</b> {{ auth('alumno')->user()->curso->nombre }}</h1>
    <br>
    <h1 id="tituloscan">¿Quieres cambiar la contraseña?</h1>

    <form action="{{ route('passalumno.panel') }}" method="POST">
        @csrf

        <label for="newpass">Nueva contraseña: </label>
        <input type="text" id="newpass" name="newpass" required>

        <button type="submit" class="btndatos" id="cambiar">Cambiar</button>
    </form>

</div>
