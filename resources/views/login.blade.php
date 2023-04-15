<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>LOGIN</h1>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <h2> Alumno: dani@gmail.com 1234 </h2>
        <h2> Admin: admin@gmail.com 1234 </h2>
        <h2> Profesor: profe@gmail.com 1234 </h2>
        <div>
            <label for="email">Correo electrónico</label>
    
            <div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    
                @error('email')
                    <span>{{ $message }}</span>
                @enderror
            </div>
        </div>
    
        <div>
            <label for="password">Contraseña</label>
    
            <div>
                <input id="password" type="password" name="password" required>
    
                @error('password')
                    <span>{{ $message }}</span>
                @enderror
            </div>
        </div>
    
        <div>
            <button type="submit">
                Iniciar sesión
            </button>
        </div>
    </form>
</body>
</html>