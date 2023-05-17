<script src="{{ asset('../resources/js/qrcode.js') }}"></script>



<div id="container">
    <div id="hidden-div">
        <div id="close-btn" class="disabled"><i class="fa-solid fa-xmark"></i></div>
        <div class="airdrop">
            <h1>Hola</h1>
        </div>
    </div>
    <div id="handle"></div>
</div>

<div class="qr">
    <button id="passList" class="btn-primary btnlista"><i class='bx bxs-check-circle'></i></button>
    <div id="qrcode" style="display: none;"></div>
    <button id="stopQr" class="btnstop btn-primary" style="display: none;"><i class='bx bx-stop-circle'></i></button>
</div>


<script>
    var boton = document.getElementById("passList");
    var botonStop = document.getElementById("stopQr");
    var qrDiv = document.getElementById("qrcode");
    var intervalId; // variable para almacenar el ID del intervalo

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


    const handle = document.getElementById('handle');
    const hiddenDiv = document.getElementById('hidden-div');
    const closeBtn = document.getElementById('close-btn');

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
</script>
