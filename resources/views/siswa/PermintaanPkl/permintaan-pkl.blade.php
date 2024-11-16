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
            vertical-align: middle;  /* Vertically centers content in cells */
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
        <div class="card">
            <div class="card-header text-bg-white">
                <div class="p-3">
                    <a href="/permintaan-pkl/create" class="btn btn-primary p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                        Buat Pengajuan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Nama Perusahaan</th>
                                <th scope="col" class="text-center">Jurusan</th>
                                <th scope="col" class="text-center">Periode</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($PengajuanPkl as $DataPengajuan)
                            {{-- @dd($DataPengajuan->perusahaan->nm_perusahaan); --}}
                                <tr>
                                    <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                    
                                    <td>{{ $DataPengajuan->perusahaan->nm_perusahaan }}</td>

                                    <td>{{ $nm_jurusan }}</td>

                                    <!-- Displaying Periode -->
                                    <td>{{ \Carbon\Carbon::parse($DataPengajuan->bulan_masuk)->format('d F Y') . ' s.d. ' .  \Carbon\Carbon::parse($DataPengajuan->bulan_keluar)->format('d F Y')}}</td>

                                    <!-- Displaying Status -->
                                    <td>
                                        @if ($DataPengajuan->status_pengajuan === "diterima")
                                          <p class="bg-green rounded font-size pb-1 pt-1 mt-3">Accept</p>
                                        @elseif ($DataPengajuan->status_pengajuan === "ditunggu")
                                          <p class="bg-warning rounded font-size pb-1 pt-1 mt-3">Pending</p>
                                        @else
                                            —
                                        @endif
                                    </td> 

                                    <!-- Action Button -->
                                    <td>
                                      @if ($DataPengajuan->status_pengajuan === "diterima")
                                      <a href="{{ route('proses.cetak.permintaan.pkl') }}" class="btn btn-warning" target="_black"><i class="fas fa-print text-white p-1 font-size"></i></a>
                                    @elseif ($DataPengajuan->status_pengajuan === "ditunggu")
                                      <a href="/cetak" class="btn btn-warning disabled"><i class="fas fa-print text-white p-1 font-size"></i></a>
                                    @else
                                        —
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
            // Initialize DataTables
            $('#myTable').DataTable();

            // Simulate a loading delay of 1 second and hide the loader
            setTimeout(function() {
                $('#loader').fadeOut();
            }, 1000);  // 1000ms = 1 second
        });

        </script>
    
    @if (Session::has('success'))
    <script>
        Swal.fire({
            title: "Sukses!",
            text: "{{ Session::get('success') }}",
            icon: "success",
            button: "OK",
        });
    </script>
    @endif
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
    {{-- @if ($errors->any())
    <script>
        let errorTitle = "Error!";
        let errorText = "Silahkan isi kembali terjadi kesalahan.";
    
        Swal.fire({
            title: errorTitle,
            text: errorText,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
    @endif --}}


</body>
</html>