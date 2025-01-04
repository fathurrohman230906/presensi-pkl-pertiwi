{{-- <!doctype html>
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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        body {
            background-color: #37517e !important;
        }
        .text-bg-white {
            background-color: white!important;
        }
        .font-size {
            font-size: 15px;
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

        .bg-green {
            background-color: lightgreen !important;
        }

        td, th {
            text-align: center;
            vertical-align: middle;
        }

        .margin-top {
            margin-top: 13rem;
        }

        #map {
            margin-top: 0px;
            border-radius: 15px;
            height: 150px;  /* Make sure the map has height */
            /* width: 50%; */
            width: 150px;
        }

        .card  {
            height: 300px;
        }
    </style>
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white fw-bold fs-2" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">Permintaan PKL</h3>
            <a href="/siswa-dashboard" class="btn btn-danger p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-md-4 col-lg-5">
                <div class="card text-bg-dark">
                    @foreach ($Presensi as $DataPresensi)
                        <img src="{{ asset('storage/FotoPresensi/' . $DataPresensi->foto) }}" class="card-img" alt="Foto Presensi">
                        <div class="card-img-overlay">
                            <div class="d-flex justify-content-end margin-top">
                                <p class="card-text"><small>{{ $DataPresensi->latitude }}</small></p>
                                <p class="card-text"><small>{{ $DataPresensi->longitude }}</small></p>
                            </div>
                            <div class="d-flex justify-content-end">
                                <p class="card-text me-2"><small>{{ \Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d F Y') }}</small></p>
                                <p class="card-text"><small>{{ $DataPresensi->masuk }}</small></p>
                            </div>

                            <div class="d-flex justify-content-start">
                                <!-- Map container inside the card -->
                                <div id="map"></div>
                            </div>
                            
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert, jQuery, DataTables, Bootstrap JS, Leaflet JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('#loader').fadeOut();
            }, 1000);
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            Swal.fire("Error", "Geolocation is not supported by this browser.", "error");
        }

        function successCallback(position) {
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Add marker for current location
            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
                .bindPopup("You are here!").openPopup();

            // Add red circle around current location
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 10
            }).addTo(map);
        }

        function errorCallback(error) {
            Swal.fire("Error", "Unable to retrieve location: " + error.message, "error");
        }
    </script>
</body>
</html> --}}
