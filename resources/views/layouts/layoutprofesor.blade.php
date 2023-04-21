<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - ClassCheck</title>

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
    <!-- BOXICONS -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- CALENDARIO -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js'></script>
    <script src="{{ asset('../resources/js/calendarProf.js') }}"></script>
    {{-- ESTILOS --}}
    <link rel="stylesheet" href="{!! asset('../resources/css/styleslayout.css') !!}">
</head>

<body>


    {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
    {{-- NAVBAR IZQUIERDA --}}
    {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
    <section id="sidebar">
        <a href="#" class="marca">
            <img class="classcheck" src="{{ asset('img/SVG/LogoSVG4.svg') }}" alt="Logo">
            <span class="texto">C L A S S C H E C K</span>
        </a>

        <ul class="side-menu top">

            <li class="active">
                <a href="#faltas">
                    <i class='bx bxs-group'></i>
                    <span class="texto">Faltas</span>
                </a>
            </li>

            <li>
                <a href="#horario">
                    <i class='bx bxs-calendar'></i>
                    <span class="texto">Horario</span>
                </a>
            </li>

            <li>
                <a href="#datos">
                    <i class='bx bxs-cog'></i>
                    <span class="texto">Datos Personales</span>
                </a>
            </li>
        </ul>


        <ul class="side-menu">
            <li class="logout">
                <form action="{{ route('procesologoutprofesor') }}" method="POST">
                    @csrf
                    <button type="submit"><i class='bx bxs-exit'></i></button>
                </form>
            </li>
        </ul>


    </section>




    {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
    {{-- NAVBAR ARRIBA --}}
    {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
    <section id="contenido">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Panel de Control</a>
            <p class="bienvenido">¡Bienvenido/a {{ auth('profesor')->user()->nombre }}!</p>


            {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
            {{-- BUSCADOR OCULTO --}}
            {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
            <form action="#">
                <div class="form-input" style="display:none;">
                    <button type="submit" class="search-btn"><i class='bx bx-search'
                            style="display:none;"></i></button>
                </div>
            </form>

            <input type="checkbox" id="modooscuro" hidden>
            <label for="modooscuro" class="modooscuro"></label>
        </nav>



        {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
        {{-- CONTENIDO --}}
        {{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
        <main>

            @yield('contenido')

        </main>

    </section>

</body>

</html>



{{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
{{-- SCRIPT MODO OSCURO --}}
{{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
<script>
    // MARCAR SELECCION SIDEBAR
    const sidemenu = document.querySelectorAll('#sidebar .side-menu.top li a');

    sidemenu.forEach(item => {
        const li = item.parentElement;

        item.addEventListener('click', function() {
            sidemenu.forEach(i => {
                i.parentElement.classList.remove('active');
            })
            li.classList.add('active');
        })
    });




    // ADAPTABILIDAD SIDEBAR
    const menuBar = document.querySelector('#contenido nav .bx.bx-menu');
    const sidebar = document.getElementById('sidebar');

    menuBar.addEventListener('click', function() {
        sidebar.classList.toggle('hide');
    })






    // MOVER SIDEBAR Y CONTENIDO
    const searchButton = document.querySelector('#contenido nav form .form-input button');
    const searchButtonIcon = document.querySelector('#contenido nav form .form-input button .bx');
    const searchForm = document.querySelector('#contenido nav form');

    searchButton.addEventListener('click', function(e) {
        if (window.innerWidth < 576) {
            e.preventDefault();
            searchForm.classList.toggle('show');
            if (searchForm.classList.contains('show')) {
                searchButtonIcon.classList.replace('bx-search', 'bx-x');
            } else {
                searchButtonIcon.classList.replace('bx-x', 'bx-search');
            }
        }
    })



    if (window.innerWidth < 768) {
        sidebar.classList.add('hide');
    } else if (window.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }


    window.addEventListener('resize', function() {
        if (this.innerWidth > 576) {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
            searchForm.classList.remove('show');
        }
    })


    // MODOOSCURO
    const switchMode = document.getElementById('modooscuro');

    switchMode.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
    })
</script>
