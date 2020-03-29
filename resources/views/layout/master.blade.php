<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Documentos QR</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>

        <div class="container">
            <div>
                <div class="navbar-header"> 
                    <a class="navbar-brand" href="/" aria-label="Argentina.gob.ar Presidencia de la Nación"> 
                        <img src="https://www.argentina.gob.ar/profiles/argentinagobar/themes/argentinagobar/argentinagobar_theme/logo.svg" alt="Argentina.gob.ar" height="50">
                    </a>
                    
                </div>
                </div>
            </div>
            
                @yield('content')

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="{{ asset('js/jsqrcode-combined.js') }}"></script>
    <script src="{{ asset('js/html5-qrcode.js') }}"></script>
</body>
<script type="text/javascript">

    $(document).ready(function() {

      $('#goButton').click(function(e) {
        window.location.href = $('#qr_url').val();


    });

    var onQRCodeFoundCallback = function (qrCodeMessage) {
        // usar url
        $("#qr").html5_qrcode_stop();
        $("#qr_url").val(qrCodeMessage);
        $("#feedback").html("Datos encontrados");
        $("#goButton").prop("disabled", false);
        if(qrCodeMessage.includes('{{ $_SERVER['HTTP_HOST'] }}')) {
            window.location.href = qrCodeMessage;
        }

    }
    var onQRCodeNotFoundCallback = function (error) {
        //$("#feedback").html('Qr Inválido! Error: ' + error);
    }
    var onVideoErrorCallback = function (videoError) {
        $("#feedback").html('Error en video : ' + videoError);
    }
    var onCamerasEnumerated = function (cameras) {
        // Cameras found.
        $("#logging").html("Cámaras: " +cameras.length);
        if (cameras.length == 0) {
            $("#feedback").html("Error: No hay cámaras habilitadas");
            return;
        }
        for (i = 0; i < cameras.length; i++) {
            var camera = cameras[i];
            var value = camera.id;
            var name = camera.label == null ? value : camera.label;
            $("#cameraSelection").append("<option value='" + value+ "'>" + name + "</option>");
        }
        $("#cameraSelection").prop("disabled", false);
        $("#cameraSelection").on("change", function () {
        });
        $("#scanButton").prop("disabled", false);

        $("#scanButton,#qr").on('click', function() {
            var cameraId = $("#cameraSelection").val();
            $("#goButton").prop("disabled", true);
            $("#feedback").html("Leyendo...");
            $("#cameraSelection").prop("disabled", true);
            $("#scanButton").prop("disabled", true);
            $("#stopButton").prop("disabled", false);
            $("#status").html('scanning');
            $('#qr').html5_qrcode(
                cameraId,
                onQRCodeFoundCallback,
                onQRCodeNotFoundCallback,
                onVideoErrorCallback,
                { fps : 5 }
            );
        });
        $("#stopButton").on('click', function() {
            $("#qr").html5_qrcode_stop();
            $("#cameraSelection").prop("disabled", false);
            $("#scanButton").prop("disabled", false);
            $("#stopButton").prop("disabled", true);
            $("#feedback").html("");
        });
    }
    var onCameraEnumerationFailed = function (errorMessage) {
        $("#feedback").html("Error: no hay cámaras: " +errorMessage);
    }
    $(document).html5_qrcode_getSupportedCameras(
        onCamerasEnumerated, onCameraEnumerationFailed);
});
</script>
</html>
