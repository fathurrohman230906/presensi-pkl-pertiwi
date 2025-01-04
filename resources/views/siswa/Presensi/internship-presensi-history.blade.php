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
    </style>
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h3 class="text-white fw-bold fs-2" style="text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);">History Presensi</h3>
            <a href="/siswa-dashboard" class="btn btn-danger p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                Kembali
            </a>
        </div>

        <div class="margin-right">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('cari.history.presensi.siswa') }}" method="post">
                        @csrf
                        <div class="row">
                            @php
                            $pilih_bulan = ['Januari' , 'Febuari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        
                        <div class="col-6 col-md-3 col-lg-5 mb-2">
                            <select class="form-select" name="bulan" aria-label="Pilih Bulan">
                                <option selected>Pilih Bulan</option>
                                @foreach ($pilih_bulan as $index => $all_bulan)
                                    <option value="{{ $index + 1 }}" {{ $bulan == $index + 1 ? 'selected' : '' }}>{{ $all_bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                            <div class="col-6 col-md-3 col-lg-5 mb-2">
                                <select class="form-select" name="tahun" aria-label="Pilih Tahun">
                                    <option selected>Pilih Tahun</option>
                                    @for ($i = 2021; $i <= 2026; $i++)
                                        <option value="{{ $i }}" {{ old('tahun', $tahun) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>                                
                            </div>
                            <div class="col-6 col-md-3 col-lg-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search me-2"></i>
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    

                    <div class="presencetab mt-2">
                        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                            <ul class="nav nav-tabs style1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Hadir</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Sakit/Izin</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content mt-2" style="margin-bottom: 100px">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <ul class="listview image-listview">
                                    <li class="p-2">
                                        @forelse ($Presensi->where('status_presensi', 'hadir') as $DataPresensi)
                                        {{-- @forelse ($Presensi->where('status_presensi', 'hadir')->whereYear('tgl_presensi', $tahun)->whereMouth('tgl_presensi', $bulan) as $DataPresensi) --}}
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h2 class="fw-bold text-uppercase">{{ $DataPresensi->siswa->nm_lengkap }}</h2>
                                                <span class="fw-bold">{{ Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d F Y') }}</span>
                                            </div>
                                            <div class="d-flex mt-2">
                                                <div class="d-flex flex-column me-4">
                                                    <h4 class="fw-bold text-uppercase">Masuk</h4>
                                                    <span class="badge fw-bold badge-success p-1 text-dark">{{ $DataPresensi->masuk }}</span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h4 class="fw-bold text-uppercase">Pulang</h4>
                                                    <span class="badge fw-bold badge-success p-1 text-dark">{{ $DataPresensi->pulang }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="fw-bold">Tidak ada history Hadir</span>
                                            </div>
                                        @endforelse
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel">
                                <ul class="listview image-listview">
                                    <li class="p-2">
                                        @forelse ($Presensi->whereIn('status_presensi', ['sakit', 'izin']) as $DataPresensi)
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h2 class="fw-bold text-uppercase">{{ $DataPresensi->siswa->nm_lengkap }}</h2>
                                                <span class="fw-bold">{{ Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d F Y') }}</span>
                                            </div>
                                            <div class="d-flex mt-1">
                                                <div class="d-flex flex-column me-4">
                                                    <h4 class="fw-bold text-uppercase">Status</h4>
                                                    <span class="badge fw-bold badge-success p-1 text-dark">{{ $DataPresensi->status_presensi }}</span>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h4 class="fw-bold text-uppercase">Keterangan</h4>
                                                    <span class="badge fw-bold badge-success p-1 text-dark">{{ $DataPresensi->keterangan }}</span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="fw-bold">Tidak ada history Sakit/Izin</span>
                                            </div>
                                        @endforelse
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="section container margin-right me-3" id="presence-section"> --}}
            {{-- </div> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- jQuery (necessary for DataTables plugin) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Owl Carousel -->
    <script src="{{ asset('assets/js/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
    <!-- jQuery Circle Progress -->
    <script src="{{ asset('assets/js/plugins/jquery-circle-progress/circle-progress.min.js') }}"></script>
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <script>
        $(document).ready(function() {
            // Simulate a loading delay of 1 second and hide the loader
            setTimeout(function() {
                $('#loader').fadeOut();
            }, 1000);  // 1000ms = 1 second
        });
    </script>
</body>
</html>