<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <h1>Hola</h1>
    <h1>Bienvenido, {{ auth('admin')->user()->nombre }}</h1>

    <form action="{{ route('logout.admin') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>