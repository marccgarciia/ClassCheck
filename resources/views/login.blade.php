<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    {{-- TAILWIND --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/flowbite.min.js"></script>
    {{-- ICONO WEB --}}
    <link rel="icon" href="{{ asset('img/SVG/LogoSVG4.svg') }}">
    {{-- JQUERY  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ESTILOS --}}
    <link rel="stylesheet" href="{!! asset('css/styleslogin.css') !!}">
</head>

<body>
    <img class="classcheck1" src="{{ asset('img/SVG/LogoSVG4.svg') }}" alt="Logo">
    <img class="classcheck2" src="{{ asset('img/SVG/LogoSVG6.svg') }}" alt="Logo">
    <div class="contenedorlogingrande">
        <div class="contenedorloginmediano">

            {{-- <h1>INICIAR SESIÓN</h1>
            <input type="email" placeholder="Correo Electrónico">
            <input type="password" placeholder="Contraseña">        

            <button type="submit">ENTRAR</button>

            <a href="">¿Has olvidado la contraseña?</a> --}}



            <h1>INICIAR SESIÓN</h1>

            <form method="POST" action="{{ route('procesologin') }}">
                @csrf

                {{-- CORREO ELECTRÓNICO --}}
                <div class="relative">
                    <input type="text" id="email" name="email" id="floating_filled"
                        class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " value="{{ old('email') }}" autofocus />
                    <label for="email"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] left-2.5 peer-focus:text-grey-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Correo
                        electrónico</label>
                </div>


                {{-- PASSWORD --}}
                <div class="relative">
                    <input type="password"id="password" name="password" id="floating_filled"
                        class="block rounded-t-lg px-2.5 pb-2.5 pt-5 w-full text-sm text-gray-900 bg-gray-50 dark:bg-gray-700 border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        placeholder=" " />
                    <label for="password"
                        class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] left-2.5 peer-focus:text-grey-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4">Contraseña</label>
                    <i class="fa-regular fa-eye" id="clickme"></i>
                    <i class="fa-regular fa-eye-slash" id="clickme2"></i>
                </div>
                <div class="errores">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <span>{{ $error }}</span>
                        @endforeach
                    @endif
                </div>



                <button type="submit">ENTRAR</button>




                <a href="{{ route('verPassword') }}">¿Has olvidado la contraseña?</a>
            </form>
        </div>
    </div>
</body>

</html>

<script>
    function verpassword(inputId) {
        var inputType = jQuery(inputId).attr('type');
        jQuery(inputId).attr('type', inputType === 'password' ? 'text' : 'password');
    }

    jQuery('#clickme').on('click', function() {
        verpassword('#password');
    });
</script>
