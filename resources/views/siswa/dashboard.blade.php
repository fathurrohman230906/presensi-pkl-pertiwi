@extends('layouts.siswa.main')

@section('content')
<style>
    .list-kegiatan {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .list-kegiatan li {
        border-bottom: 1px solid #ccc; /* Garis horizontal */
        padding: 5px;
    }
    .item {
        display: flex;
        align-items: center;
    }
    .left {
        width: 40%; /* Atur lebar sesuai kebutuhan */
    }
    .right {
        width: 100%; /* Mengisi penuh */
    }
    .ine {
        display: flex;
        flex-direction: column;
    }
    .presencetab {
        padding-bottom: 5rem;
    }
    /* Menambahkan kelas untuk link yang dinonaktifkan */
    .disabled-link {
        pointer-events: none; /* Nonaktifkan klik */
        opacity: 0.6; /* Menambahkan transparansi agar terlihat tidak aktif */
    }
</style>

<div class="section" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <!-- Kartu Masuk -->
                <a href="/internship-presensi" class="@if ($absen_masuk > 0 || $absen_pulang > 0 || $status_absen > 0){{ 'disabled-link' }}@else{{ '' }}@endif">
                    <div class="card gradasigreen">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ Carbon\Carbon::parse($jam_masuk)->format('H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>            
            </div>
            <div class="col-6">
                <!-- Kartu Pulang -->
                <a href="/internship-presensi/pkl" onclick="absenPulang(event)" class="@if ($absen_masuk == 0 || $absen_pulang > 0 || $status_absen > 0){{ 'disabled-link' }}@else{{ '' }}@endif">
                    <div class="card gradasired">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    <ion-icon name="camera"></ion-icon>
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <p id="testing"></p>
                                    <span>{{ Carbon\Carbon::parse($jam_keluar)->format('H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="presencetab">
        <div class="tab-pane" id="profile" role="tabpanel">
            <div class="row mb-2 d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="rekappresencetitle text-center mt-1">Kegiatan Harian</h4>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="list-kegiatan listview image-listview">
                @if ($KegiatanPkl && $KegiatanPkl->count() > 0)
                    @foreach ($KegiatanPkl as $DataKegiatan)
                        @php
                            $tgl_kegiatan = \Carbon\Carbon::parse($DataKegiatan->tgl_kegiatan)->format('d F Y');
                            $waktu = \Carbon\Carbon::parse($DataKegiatan->created_at)->format('H:i:s');
                        @endphp
                        <li>
                            <div class="item right">
                                <div class="in">
                                    <div>{{ $DataKegiatan->deskripsi_kegiatan }}</div>
                                    <div class="ine">
                                        <span class="text-muted">{{ $tgl_kegiatan }}</span>
                                        <span class="text-muted">{{ $waktu }}</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <div class="item right">
                            <div class="in">
                                <div class="p-2">Tidak ada kegiatan hari ini</div>
                            </div>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

<!-- Modal pulang cepat -->
<div class="modal fade" id="pulangCepat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pulangCepatLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="pulangCepatLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            @php
                date_default_timezone_set('Asia/Jakarta');  // Mengatur zona waktu ke Jakarta
                $now = new DateTime();  // Mendapatkan waktu saat ini
            @endphp
            <form action="{{ route('pulang.cepat.presensi.siswa') }}" method="post" enctype="multipart/form-data">
                @csrf
                <select name="status_presensi" class="form-select mb-3" aria-label="Default select example">
                    <option selected>Pilih Alasan Pulang Cepat</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                  </select>
                <input type="hidden" name="nis" value="{{ session('nis') }}">
                <input type="hidden" name="perusahaanID" value="{{ $perusahaanID }}">
                <input type="hidden" id="lokasi" name="lokasi">
                <input type="hidden" name="status_absen" value="pulang-cepat">
                <input type="hidden" name="tgl_presensi" value="{{ $now->format('Y-m-d') }}">

                <div class="form-group">
                    <label for="alasan">Keterangan Pulang cepat</label>
                    <textarea class="form-control" id="alasan" name="keterangan" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Bukti Surat</label>
                    <input class="form-control" type="file" name="foto" id="formFile">
                </div>

                <button class="btn btn-warning w-100">
                    <i class="bi bi-person-check fs-5 me-2"></i>
                    Kirim
                </button>
            </form>
        </div>
      </div>
    </div>
  </div>

@if (Session::has('success'))
    <script>
        setTimeout(function() {
            Swal.fire({
                title: "Sukses!",
                text: "{{ Session::get('success') }}",
                icon: "success",
                button: "OK",
            });
        }, 500);  // Delay in milliseconds (500ms)
    </script>
@endif

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
@if (Session::has('pulang_awal'))
    <script>
            setTimeout(function() {
                Swal.fire({
                    title: "Pulang Sekarang?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Iya, Pulang sekarang"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, redirect to the link
                        if (result.isConfirmed) {
                            var myModal = new bootstrap.Modal(document.getElementById('pulangCepat'), {
                                keyboard: false
                            });
                            myModal.show();
                        }
                    }
                });
            }, 500);  
    </script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
            var lokasi = document.getElementById('lokasi');
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
        }

        function errorCallback(error) {
            Swal.fire("Peringatan", "silahkan aktifkan lokasi anda", "info");
        }

    function absenPulang(event) {
        event.preventDefault(); // Prevent default behavior of the link click

        let jam_keluar = "{{ $jam_keluar }}";
        let jam_Sekarang = "{{ Carbon\Carbon::now('Asia/Jakarta')->format('H:i:s') }}";

        // If jam_keluar is greater or equal to jam_Sekarang, show the confirmation dialog
        if (jam_keluar >= jam_Sekarang) { 
            setTimeout(function() {
                Swal.fire({
                    title: "Pulang Sekarang?",
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Iya, Pulang sekarang"
                }).then((result) => {
                    if (result.isConfirmed) {
                        var myModal = new bootstrap.Modal(document.getElementById('pulangCepat'), {
                            keyboard: false
                        });
                        myModal.show();
                    }
                });
            }, 500);
        } else {
            // If jam_keluar is less than jam_Sekarang, directly navigate to the link
            window.location.href = "/internship-presensi/pkl";
        }
    }


    @if ($absen_masuk > 0)
    var jamMasuk = "{{ Carbon\Carbon::parse($jam_masuk)->format('H:i') }}";
    @else    
    // Mendapatkan waktu jam_masuk yang sudah di-parse ke format H:i
    var jamMasuk = "{{ Carbon\Carbon::parse($jam_masuk)->format('H:i') }}";
// Parse the jam_keluar value and convert it into a time format (HH:mm:ss)
    var now = new Date();

    var currentTime = now.getHours() + ':' + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();

    // Membandingkan waktu sekarang dengan jam masuk
    var jamMasukParts = jamMasuk.split(':');
    var currentTimeParts = currentTime.split(':');

    var jamMasukMinutes = parseInt(jamMasukParts[0]) * 60 + parseInt(jamMasukParts[1]);
    var currentTimeMinutes = parseInt(currentTimeParts[0]) * 60 + parseInt(currentTimeParts[1]);

    @if ($status_absen === 0)
    // Jika waktu sekarang lebih dari 5 menit setelah jam masuk
    if (currentTimeMinutes > jamMasukMinutes + 5) {
        // Tampilkan peringatan menggunakan SweetAlert
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: 'Anda terlambat lebih dari 5 menit!',
        });
    }
    @endif

    @endif

    $(document).ready(function() {
        // Handle webcam and geolocation as before
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
        
        // Set up geolocation
        var lokasi = document.getElementById('lokasi');
        var status_absen_masuk = document.getElementById('status_absen_masuk');
        status_absen_masuk.value = 'masuk';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        } else {
            Swal.fire("Error", "Geolocation is not supported by this browser.", "error");
        }

        function successCallback(position) {
            lokasi.value = JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            });

            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([position.coords.latitude, position.coords.longitude]).addTo(map)
                .bindPopup("You are here!").openPopup();
            var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 20
            }).addTo(map);
        }

        function errorCallback(error) {
            Swal.fire("Error", "Unable to retrieve location: " + error.message, "error");
        }

        // Handle the 'Take Absensi' button click
        $('#takeabsen').click(function(e) {
            Webcam.snap(function(uri) {
               image = uri; 
            });

            var lokasi = $("lokasi").val();
            foto.value = image;
        });
    });
</script>

@endsection
