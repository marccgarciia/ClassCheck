<!-- HTML -->
<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

<div id="respuesta" class="camara">
    
</div>

<script>
    // JavaScript
    comprobarClase()

    
    function comprobarClase() {
    const ajax = new XMLHttpRequest();
    ajax.open('GET', 'comprobarClase');
    ajax.onload = () => {
        if (ajax.status == 200) {
            respuesta = JSON.parse(ajax.responseText);
            let curso = respuesta.id;
            let asignatura = respuesta.idAs;
            let hora = respuesta.hora;

            console.log(respuesta);
            if(respuesta.tieneAsignatura && !respuesta.pasadoLista){
                document.getElementById("respuesta").innerHTML = `
                <h1 id="tituloscan">¡DATE PRISA Y ESCANEA EL QR!</h1>
                <button id="scan" class="btn btn-primary"><i class='bx bx-scan'></i></button>
                <div class="qr-scanner" id="qrScan" style="display: none;">
                    <div class="box">
                        <div class="line"></div>
                        <div class="angle"></div>
                        <video id="preview"></video>
                    </div>
                </div>
                <p id="qr-text"></p>
                `
                
                var boton = document.getElementById("scan");

                boton.addEventListener("click", function() {
                    // Obtener el elemento de vídeo y el párrafo
                    var video = document.getElementById('preview');
                    var qrText = document.getElementById('qr-text');
                    var preview = document.getElementById("preview");
                    var qrScan = document.getElementById("qrScan");

                    var stream = null;
                    if (qrText) {
                        qrText.innerHTML = "";
                    }

                    // Crear un escáner de códigos QR
                    var scanner = new Instascan.Scanner({
                        video: video
                    });
                    //preview.style.display = "block";
                    qrScan.style.display = "block";


                    // Agregar un evento de detección de códigos QR
                    scanner.addListener('scan', function(content) {
                        let session = "{{ auth('alumno')->user()->id }}";
                        // Mostrar la información del código QR en el párrafo
                        qrText.innerHTML = 'El código QR contiene: ' + content + ' Alumno:' + session;

                        pasarListaAlu(content,session);

                        // Ocultar la cámara y mostrar el botón de escaneo
                        scanner.stop();
                        qrScan.style.display = "none";
                        boton.style.display = "block";
                    });

                    function pasarListaAlu(content,session){
                        console.log(content,session)
                    }

                    // Iniciar el escáner
                    Instascan.Camera.getCameras().then(function(cameras) {
                        if (cameras.length > 1) {
                            scanner.start(cameras[1]);
                        } else if (cameras.length > 0) {
                            scanner.start(cameras[0]);
                        } else {
                            console.error('No hay cámaras disponibles.');
                        }
                    }).catch(function(e) {
                        console.error(e);
                    });

                    navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: "environment"
                        }
                    }).then(function(stream) {
                        var video = document.querySelector('video');
                        video.srcObject = stream;
                        video.onloadedmetadata = function(e) {
                            video.play();
                        };
                    }).catch(function(err) {
                        alert(err.name + ": " + err.message);
                    });

                    // Ocultar el botón de escaneo y mostrar la cámara
                    boton.style.display = "none";
                    qrScan.style.display = "block";
                    //preview.style.display = "block";
                });
            }else if(respuesta.tieneAsignatura && respuesta.pasadoLista){
                let alumno = "{{ auth('alumno')->user()->nombre }}"+ " " + "{{ auth('alumno')->user()->apellido }}";
                document.getElementById("respuesta").innerHTML = `
                <div class="btn-primary btnNolista">
                    <i class='bx bx-error-circle'></i>
                    <p>${alumno} ya has confirmado tu asistencia, o tu profesor todavía no ha pasado la lista</p>
                </div>
                `
            }else{
                let alumno = "{{ auth('alumno')->user()->nombre }}"+ " " + "{{ auth('alumno')->user()->apellido }}";
                document.getElementById("respuesta").innerHTML = `
                <div class="btn-primary btnNolista">
                    <i class='bx bx-error-circle'></i>
                    <p>${alumno} no tienes clase, puedes seguir jugando</p>
                </div>
                `
            }
        }
    };
    ajax.send();
    }
</script>
