<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Demo with DataTables</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Font Awesome (latest version) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <style>
        body {
            background-color: #37517e !important;
        }

        #loader {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #loader .loading-icon {
            width: 42px;
            height: auto;
            animation: loadingAnimation 1s infinite;
        }
        @keyframes loadingAnimation {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .margin-top {
            margin-top: 4rem;
        }

        .webcam-capture,
        .webcam-capture video {
            display: inline-block;
            width: 100% !important;
            margin: auto !important;
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white fw-bold fs-2" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">Presensi PKL</h3>
            <a href="/siswa-dashboard" class="btn btn-danger p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                Kembali
            </a>
        </div>

        <div class="d-flex justify-content-center margin-top">
            <form action="/internship-presensi/presensi" method="post">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="nis" value="{{ session('nis') }}">
                        <input type="hidden" id="lokasi" name="lokasi">
                        <div class="webcam-capture"></div>
                    </div>
                </div>
                <button type="submit">Kirim</button>
            </form>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (necessary for DataTables plugin) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            // Simulate a loading delay of 1 second and hide the loader
            setTimeout(function() {
                $('#loader').fadeOut();
            }, 1000);  // 1000ms = 1 second
            Webcam.set({
                width: 540, 
                height: 380, 
                image_format: 'jpeg',  
                jpeg_quality: 90  
            });

            if (Webcam.init()) {
                console.log("Webcam is ready!");
            } else {
                console.log("Webcam initialization failed.");
            }

            Webcam.attach('.webcam-capture');

        });
        var lokasi = document.getElementById('lokasi');

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
} else {
    Swal.fire("Error", "Geolocation is not supported by this browser.", "error");
}

function successCallback(position) {
    // Storing the coordinates in an array
    lokasi.value = JSON.stringify({
        latitude: position.coords.latitude,
        longitude: position.coords.longitude
    });
}

function errorCallback(error) {
    Swal.fire("Error", "Unable to retrieve location: " + error.message, "error");
}

    </script>
    

</body>
</html>
