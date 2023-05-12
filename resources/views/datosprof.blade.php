<div class="divdatos">
    <h1 id="tituloscan"> DATOS PERSONALES</h1>
    <h1><b>Nombre:</b> {{ auth('profesor')->user()->nombre }}</h1>
    <h1><b>Apellido:</b> {{ auth('profesor')->user()->apellido }}</h1>
    <h1><b>Correo Electrónico:</b> {{ auth('profesor')->user()->email}}</h1>
    <br>
    <h1 id="tituloscan">¿Quieres cambiar la contraseña?</h1>

    <form action="{{ route('passprofe.panel') }}" method="POST">
        @csrf

        <label for="newpass">Nueva contraseña: </label>
        <input type="text" id="newpass" name="newpass" required>

        <button type="submit" class="btndatos">Cambiar</button>
    </form>
</div>
