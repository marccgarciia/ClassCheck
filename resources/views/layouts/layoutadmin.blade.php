<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo') - ClassCheck</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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
    {{-- ESTILOS --}}
    <link rel="stylesheet" href="{!! asset('../resources/css/styleslayout.css') !!}">
    {{-- ESTILOS MODAL--}}
    <link rel="stylesheet" href="{!! asset('../resources/css/stylesmodal.css') !!}">

    <script src='{!! asset('../resources/js/gestionAdmin.js') !!}'></script>
    <meta name='csrf-token' content="{{ csrf_token() }}" id="token" />
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
                <a href="{{ route('webalumnos') }}">
                    <i class='bx bxs-group'></i>
                    <span class="texto">Alumnos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('webcursos') }}">
                    <i class='bx bxs-graduation'></i>
                    <span class="texto">Cursos</span>
                </a>
            </li>

            <li>
                <a href="{{ route('webprofesores') }}">
                    <i class='bx bxs-user-circle'></i>
                    <span class="texto">Profesores</span>
                </a>
            </li>

            <li>
                <a href="{{ route('webasignaturas') }}">
                    <i class='bx bx-library'></i>
                    <span class="texto">Asignaturas</span>
                </a>
            </li>
        </ul>


        <ul class="side-menu">
            <li class="logout">
                <form action="{{ route('procesologoutadmin') }}" method="POST">
                    @csrf
                    <button type="submit" class="log"><i class='bx bx-log-out'></i></button>
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
            <p class="bienvenido">¡Bienvenido/a {{ auth('admin')->user()->nombre }} {{ auth('admin')->user()->apellido }}!</p>

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


            <div id="paneldecontrol">
                <ul class="box-info">

                    <li>
                        <i class='bx bxs-calendar-check'></i>
                        <span class="texto">
                            <h3 id="cursosN">55</h3>
                            <p>Cursos</p>
                        </span>
                    </li>

                    <li>
                        <i class='bx bxs-group'></i>
                        <span class="texto">
                            <h3 id="alumnosN">2834</h3>
                            <p>Alumnos</p>
                        </span>
                    </li>


                    <li>
                        <i class='bx bx-library'></i>
                        <span class="texto">
                            <h3 id="asignaturasN">254</h3>
                            <p>Total Asignaturas</p>
                        </span>
                    </li>

                </ul>
            </div>


            <div id="contenedor-contenido">
                @yield('contenido')

            </div>


        </main>

    </section>

</body>

</html>



{{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
{{-- SCRIPT MODO OSCURO --}}
{{-- ::::::::::::::::::::::::::::::::::::::::::::: --}}
<script>
    function actualizarContadores() {
        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "countcur", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cursosN").innerHTML = JSON.parse(this.responseText).count;
            } else if (this.readyState == 4 && this.status != 200) {
                console.log('Error:', this.status, this.statusText);
            }
        };
        xhttp.send();

        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "countalu", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("alumnosN").innerHTML = JSON.parse(this.responseText).count;
            } else if (this.readyState == 4 && this.status != 200) {
                console.log('Error:', this.status, this.statusText);
            }
        };
        xhttp.send();

        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "countasi", true);
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("asignaturasN").innerHTML = JSON.parse(this.responseText).count;
            } else if (this.readyState == 4 && this.status != 200) {
                console.log('Error:', this.status, this.statusText);
            }
    };
    xhttp.send();
}

// Llamar a la función cada 5 segundos
actualizarContadores();
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
