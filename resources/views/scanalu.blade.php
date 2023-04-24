    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <video id="preview"></video>
    <p id="qr-text"></p>
    <script>
        // Obtener el elemento de vídeo y el párrafo
        var video = document.getElementById('preview');
        var qrText = document.getElementById('qr-text');
        
        // Crear un escáner de códigos QR
        var scanner = new Instascan.Scanner({ video: video });
        
        // Agregar un evento de detección de códigos QR
        scanner.addListener('scan', function (content) {
            // Mostrar la información del código QR en el párrafo
            qrText.innerHTML = 'El código QR contiene: ' + content + ' Alumno: Edgar';
        });
        
        // Iniciar el escáner
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 1) {
                scanner.start(cameras[1]);
            } else if (cameras.length > 0) {
                scanner.start(cameras[0]);
            }else {
                console.error('No hay cámaras disponibles.');
            }
        }).catch(function (e) {
            console.error(e);
        });
    </script>

<script>
    navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
      .then(function(stream) {
        var video = document.querySelector('video');
        video.srcObject = stream;
        video.onloadedmetadata = function(e) {
          video.play();
        };
      })
      .catch(function(err) {
        alert(err.name + ": " + err.message);
      });
</script>
