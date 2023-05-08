<div class="divdatos">
    <h1><b>Nombre:</b> Pepe</h1>
    <h1><b>Correo Electrónico:</b> Pepe</h1>
    <h1><b>Dirección:</b> Pepe</h1>
    <h1><b>Curso:</b> Pepe</h1>
    <br>
    <h1 id="tituloscan">¿Quieres cambiar la contraseña?</h1>

    <form action="{{ route('passalumno.panel') }}" method="POST">
        @csrf

        <label for="newpass">Nueva contraseña: </label>
        <input type="text" id="newpass" name="newpass" required>

        <button type="submit" class="btndatos">Cambiar</button>
    </form>

</div>
