<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Principal</h1>
    <a href="{{ route('webalumnos') }}">ALUMNOS</a>
    <a href="{{ route('webcursos') }}">CURSOS</a>
    <a href="{{ route('webprofesores') }}">PROFESORES</a>
    <a href="{{ route('webasignaturas') }}">ASIGNATURAS</a>
</body>

</html>
