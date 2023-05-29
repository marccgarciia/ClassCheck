<!DOCTYPE html>
<html>

<head>
    <title>Cargando - ClassCheck</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --color-negro: #000;
            --color-azuloscuro: #142c44;
            --color-azulclaro: #2b4d6d;
            --color-azulmasclaro: #85b7e5;
            --color-gris: #eee;
            --color-blanco: #ffff;
            --color-input: #ffff;
            --color-texto-input: #142c44;
            --color-texto: #142c44;
            --rojo: #DB504A;
            --fc-border-color: #eeeeee;
        }

        body.dark {
            --color-azulclaro: #0C0C1E;
            --color-gris: #142c44;
            --color-blanco: #FBFBFB;
            --color-texto: #FBFBFB;
            --color-input: #2b4d6d;
            --color-texto-input: #85b7e5;
        }

        body {
            background-color: #142c44;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .loader {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .circle {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 7px solid #f3f3f3;
            border-top: 7px solid #2b4d6d;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .check-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 48px;
        }
    </style>
</head>

<body>
    <div class="loader">
        <div class="circle"></div>
        <i class="fas fa-check check-icon"></i>
    </div>
</body>

</html>
