<script src="{{ asset('../resources/js/qrcode.js') }}"></script>


<div id="respuesta" class="qr"></div>


<div id="container">
    
</div>


<script>
    profeClase();
    function profeClase() {
    const ajax = new XMLHttpRequest();
    ajax.open('GET', 'claseprof');
    ajax.onload = () => {
        if (ajax.status == 200) {
            respuesta = JSON.parse(ajax.responseText);
            var curso = respuesta.id;
            // console.log(respuesta);
            if(respuesta.tieneAsignatura){
                document.getElementById("respuesta").innerHTML = `
                <h1 id="tituloscan">Curso: ${respuesta.curso}, Módulo: ${respuesta.asignatura}</h1>
                <button id="passList" class="btn-primary btnlista"><i id="check" class='bx bxs-check-circle'></i>
                <p>Tienes preparada tu clase, pase la lista</p></button>
                <div id="qrcode" style="display: none;"></div>
                <button id="stopQr" class="btnstop btn-primary" style="display: none;"><i class='bx bx-stop-circle'></i></button>
                `
                document.getElementById("container").innerHTML = `
                <div id="hidden-div">
                    <div id="close-btn" class="disabled"><i class="fa-solid fa-xmark"></i></div>
                    <div id="listaClase" class="airdrop">
                    </div>
                </div>
                <div id="handle"></div>
                `
                let boton = document.getElementById("passList");
                let botonStop = document.getElementById("stopQr");
                let qrDiv = document.getElementById("qrcode");
                let intervalId;

                boton.addEventListener("click", function() {
                // Crear el nuevo código QR
                    qrcode = new QRCode(qrDiv, {
                        text: new Date().toLocaleString(),
                        width: 256,
                        height: 256,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });

                    // Generar un nuevo código QR cada 10 segundos
                    intervalId = setInterval(function() {
                        qrDiv.innerHTML = "";

                        // Crear el nuevo código QR
                        qrcode = new QRCode(qrDiv, {
                            text: new Date().toLocaleString(),
                            width: 256,
                            height: 256,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }, 5000);

                    // Ocultar el botón de escaneo y mostrar la cámara
                    boton.style.display = "none";
                    botonStop.style.display = "block";
                    qrDiv.style.display = "flex";
                });

                botonStop.addEventListener("click", function() {
                    qrDiv.innerHTML = "";
                    boton.style.display = "block";
                    botonStop.style.display = "none";
                    qrDiv.style.display = "none";
                    clearInterval(intervalId); // detener el intervalo
                });
                
                var handle = document.getElementById('handle');
                var hiddenDiv = document.getElementById('hidden-div');
                var closeBtn = document.getElementById('close-btn');

                handle.addEventListener('click', () => {
                    hiddenDiv.style.right = '0';
                    closeBtn.classList.add('visible');
                    closeBtn.classList.remove('disabled');
                });

                closeBtn.addEventListener('click', () => {
                    hiddenDiv.style.right = '-300px';
                    closeBtn.classList.remove('visible');
                    closeBtn.classList.add('disabled');
                });

                closeBtn.addEventListener('mouseenter', () => {
                    if (closeBtn.classList.contains('disabled')) {
                        closeBtn.style.cursor = 'default';
                    } else {
                        closeBtn.style.cursor = 'pointer';
                    }
                });

                closeBtn.addEventListener('mouseleave', () => {
                    closeBtn.style.cursor = 'default';
                });
                listaClase(curso);
            }else{
                document.getElementById("respuesta").innerHTML = `
                <div class="btn-primary btnNolista">
                    <i class='bx bx-error-circle'></i>
                    <p>A esta hora no tienes clases, tómate un descanso</p>
                </div>
                `
            }
        }
    };
    ajax.send();
    }

    function listaClase(curso){
        // console.log(curso);
        let lista = document.getElementById("listaClase");
        var csrf_token = token.content;
        const ajax = new XMLHttpRequest();
        let formdata = new FormData();
        formdata.append('_token', csrf_token);
        formdata.append('curso', curso);

        ajax.open('POST', 'listaalumnos');
        ajax.onload = () => {
            if (ajax.status == 200) {
                respuesta = JSON.parse(ajax.responseText);
                console.log(respuesta);
                respuesta.forEach(function (alumno) {
                    lista.innerHTML += `
                        <h1>${alumno.nombre} ${alumno.apellido}</h1>
                    `
                });
            }
        }
        ajax.send(formdata);
    }

    closeBtn.addEventListener('mouseleave', () => {
        closeBtn.style.cursor = 'default';
    });
</script>
