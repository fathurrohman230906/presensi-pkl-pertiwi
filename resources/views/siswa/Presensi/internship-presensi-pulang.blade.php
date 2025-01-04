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

    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

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
        
        /* Define the height for the map */
        #map {
            border-radius: 15px;
            height: 400px;  /* Make sure the map has height */
            /* width: 100%; */
            width: 400px;
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
            <form action="/internship-presensi/presensi-pulang" method="post">
                @csrf
                @php
                    date_default_timezone_set('Asia/Jakarta');  // Mengatur zona waktu ke Jakarta
                    $now = new DateTime();  // Mendapatkan waktu saat ini
                @endphp
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="nis" value="{{ session('nis') }}">
                        <input type="hidden" id="lokasi" name="lokasi">
                        <input type="hidden" id="foto" name="foto_pulang">
                        <div class="webcam-capture"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button id="takeabsen" class="btn btn-primary btn-block">
                            <i class="bi bi-camera fs-5 me-2"></i>
                            Absen Pulang
                        </button>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col">
                        <div id="map" class="mt-3"></div>
                    </div>
                </div>
            {{-- </form> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (necessary for DataTables plugin) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function() {
            // Simulate a loading delay of 1 second and hide the loader
            setTimeout(function() {
                $('#loader').fadeOut();
            }, 1000);  // 1000ms = 1 second

            // Webcam setup
            Webcam.set({
                width: 540, 
                height: 380, 
                image_format: 'jpeg',  
                jpeg_quality: 90  
            });

            if (Webcam.init()) {
                console.log("Webcam is ready!");
            } else {
                // Swal.fire("Peringatan", "Peringatan camera webcam anda mati", "info");
                // let takeabsen = document.getElementById('takeabsen');
                // takeabsen.style.display = 'none';
                console.log("Webcam initialization failed.");
            }

            Webcam.attach('.webcam-capture');
        });

        var lokasi = document.getElementById('lokasi');
        var foto = document.getElementById('foto');

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

            // Initialize the map with the user's current location
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Add a marker for the current location
            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
                .bindPopup("You are here!")
                .openPopup();
            // add lingkaran merah
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        }

        function errorCallback(error) {
            Swal.fire("Peringatan", "Peringatan camera webcam anda mati", "info");
        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
               image = uri; 
            });

            var lokasi = $("lokasi").val();
            foto.value = image;
        });
    </script>

@if (Session::has('peringatan'))
<script>
    Swal.fire({
        title: "Peringatan!",
        text: "{{ Session::get('peringatan') }}",
        icon: "info",
        button: "OK",
    });
</script>
@endif

@if(session('errorDetails'))
    <script>
        console.error('Error Details:', @json(session('errorDetails')));
    </script>
@endif 
</body>
</html>
