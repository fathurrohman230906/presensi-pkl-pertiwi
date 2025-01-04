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

    <!-- Webcam.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>

    <!-- Favicon and icons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white fw-bold fs-2" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">Presensi PKL</h3>
            <a href="/siswa-dashboard" class="btn btn-danger p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                Kembali
            </a>
        </div>

        <div class="d-flex justify-content-center margin-top">
            @php
                date_default_timezone_set('Asia/Jakarta');  // Mengatur zona waktu ke Jakarta
                $now = new DateTime();  // Mendapatkan waktu saat ini
            @endphp
            <form action="/internship-presensi/presensi" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        <input type="hidden" name="nis" value="{{ session('nis') }}">
                        <input type="hidden" name="perusahaanID" value="{{ $perusahaanID }}">
                        <input type="hidden" id="lokasi" name="lokasi">
                        <input type="hidden" name="tgl_presensi" value="{{ $now->format('Y-m-d') }}">
                        <input type="hidden" name="masuk" value="{{ $now->format('H:i:s') }}">
                        <input type="hidden" name="status_presensi" value="hadir">
                        <input type="hidden" id="foto" name="foto">
                        <div class="webcam-capture"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button id="takeabsen" class="btn btn-primary btn-block">
                            <i class="bi bi-camera fs-5 me-2"></i>
                            Absen Masuk
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="row d-none">
                <div class="col">
                    <div id="map" class="mt-3"></div>
                </div>
            </div>
         </div>

        <div class="container margin-button">
            <div class="d-flex justify-content-center mt-2 mb-5">
                <div class="row w-50">
                    <div class="col-6 col-md-12 col-lg-6 mt-2">
                        <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#sakit">
                            <i class="bi bi-heart-pulse fs-5 me-2"></i>
                            Sakit
                        </button>
                    </div>
                    <div class="col col-md-6 col-lg-6 mt-2">
                        <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#izin">
                            <i class="bi bi-person-check fs-5 me-2"></i>
                            Izin
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal sakit -->
    <div class="modal fade" id="sakit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sakitLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="sakitLabel">Alasan Sakit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sakit.izin.presensi.siswa') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status_presensi" value="sakit">
                        <input type="hidden" name="nis" value="{{ session('nis') }}">
                        <input type="hidden" name="perusahaanID" value="{{ $perusahaanID }}">
                        <input type="hidden" id="lokasi_sakit" name="lokasi">
                        <input type="hidden" name="tgl_presensi" value="{{ $now->format('Y-m-d') }}">
                        
                        <div class="form-group">
                            <label for="alasan">Alasan Sakit:</label>
                            <textarea class="form-control" id="alasan" name="keterangan" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Bukti Surat</label>
                            <input class="form-control" type="file" name="foto" id="formFile">
                        </div>
                    
                        <button class="btn btn-danger w-100">
                            <i class="bi bi-heart-pulse fs-5 me-2"></i>
                            Sakit
                        </button>
                    </form>                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Izin -->
    <div class="modal fade" id="izin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="izinLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="izinLabel">Alasan Izin</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('sakit.izin.presensi.siswa') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="status_presensi" value="izin">
                        <input type="hidden" name="nis" value="{{ session('nis') }}">
                        <input type="hidden" name="perusahaanID" value="{{ $perusahaanID }}">
                        <input type="hidden" id="lokasi_izin" name="lokasi">
                        <input type="hidden" name="tgl_presensi" value="{{ $now->format('Y-m-d') }}">

                        <div class="form-group">
                            <label for="alasan">Alasan Izin:</label>
                            <textarea class="form-control" id="alasan" name="keterangan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Bukti Surat</label>
                            <input class="form-control" type="file" name="foto" id="formFile">
                        </div>

                        <button class="btn btn-warning w-100">
                            <i class="bi bi-person-check fs-5 me-2"></i>
                            Izin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
                // Swal.fire("Peringatan", "Peringatan camera webcam anda mati atau lokasi anda tidak di aktifkan", "info");
                // let takeabsen = document.getElementById('takeabsen');
                // takeabsen.style.display = 'none';
                console.log("Webcam initialization failed.");
            }

            Webcam.attach('.webcam-capture');
        });

        var lokasi = document.getElementById('lokasi');
        var lokasi_sakit = document.getElementById('lokasi_sakit');
        var lokasi_izin = document.getElementById('lokasi_izin');
        var foto = document.getElementById('foto');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            Swal.fire("Peringatan", "Silahkan Aktifkan Lokasi anda.", "info");
        }

        function successCallback(position) {
            lokasi.value = JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            });
            lokasi_sakit.value = JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            });
            lokasi_izin.value = JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            });

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
                .bindPopup("You are here!")
                .openPopup();

            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        }

        function errorCallback(error) {
            Swal.fire("Peringatan", "silahkan aktifkan lokasi anda", "info");
        }

        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
                var image = uri; 
                foto.value = image;
            });
        });
    </script>

    @if (Session::has('peringatan'))
    <script>
        setTimeout(function() {
            Swal.fire({
                title: "Peringatan!",
                text: "{{ Session::get('peringatan') }}",
                icon: "info",
                button: "OK",
            });
        }, 500);
    </script>
    @endif

    @if(session('errorDetails'))
    <script>
        console.error('Error Details:', @json(session('errorDetails')));
    </script>
@endif

</body>
</html>