@extends('layouts.main')
@section('content')
<style>
    .breadcrumb {
        border: none;
    }

    .modal-content img {
        max-width: 100%;
        height: auto;
    }

    /* Custom card styles */
    .custom-card {
        border-radius: 15px;
        border: 1px solid #ddd;
        padding: 20px;
        background-color: #f9f9f9;
    }

    .custom-card-header {
        background-color: #007bff;
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 15px;
        font-weight: bold;
    }

    .custom-card-body {
        padding: 25px;
    }
</style>

<h3 class="fw-bold mb-3">Kelola Presensi</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Presensi</li>
    </ol>
</nav>
@php
    $kelasID = $kelasID ?? null;
    $siswa = App\Models\Siswa::with('kelas')->where('kelasID', $kelasID)->get();
@endphp
<div class="card mt-3 custom-card">
    <div class="custom-card-header">
        <h5>Filter Data Presensi</h5>
    </div>
    <div class="custom-card-body">
        <form action="{{ route('kelola.presensi.search') }}" method="post" class="p-2 mb-3">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8 col-lg-3">
                    <form action="" method="post" class="d-none"></form>
                    <form action="{{ route('cari.siswa.presensi.admin') }}" id="myForm" method="post">
                        @csrf
                        <select class="form-select" id="mySelect" name="kelasID" aria-label="Pilih Siswa">
                            <option selected disabled>Pilih Kelas</option>
                            @foreach ($kelas as $Datakelas)
                                <option value="{{ $Datakelas->kelasID }}"
                                    @if (!empty($kelasID))
                                        {{ old('kelasID', $kelasID) == $Datakelas->kelasID ? 'selected' : '' }}
                                    @endif
                                >{{ $Datakelas->nm_kelas }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                
                @if($kelasID && $siswa->count() > 0)
                <div class="col-12 col-md-8 col-lg-3">
                    <select class="form-select" name="nis" aria-label="Pilih Siswa">
                        <option selected disabled>Pilih Siswa</option>
                        @foreach ($siswa as $DatasSiswa)
                            <option value="{{ $DatasSiswa->nis }}"
                                @if (!empty($nis))
                                    {{ old('nis', $nis) == $DatasSiswa->nis ? 'selected' : '' }}
                                @endif
                            >{{ $DatasSiswa->nm_lengkap }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-12 col-md-8 col-lg-3">
                    <select class="form-select" name="perusahaanID" aria-label="Pilih Perusahaan">
                        <option selected disabled>Pilih Perusahaan</option>
                        @foreach ($perusahaan as $Dataperusahaan)
                        <option value="{{ $Dataperusahaan->perusahaanID }}"
                        @if (!empty($perusahaanID))
                        {{ old('perusahaanID', $perusahaanID) == $Dataperusahaan->perusahaanID ? 'selected' : '' }}
                        @endif    
                        >{{ $Dataperusahaan->nm_perusahaan }}</option>                        
                        @endforeach
                    </select>
                </div>
                
                <div class="col-12 col-md-4 col-lg-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered shadow-sm rounded" id="myTable">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama Siswa</th>
                        <th scope="col" class="text-center">Nama Perusahaan</th>
                        <th scope="col" class="text-center">Status Presensi</th>
                        @php
                            $statusPresensi = $Presensi->isNotEmpty() ? $Presensi->first()->status_presensi : null;
                        @endphp
                        @if ($statusPresensi === "sakit" || $statusPresensi === "izin")
                            <th scope="col" class="text-center">Keterangan</th>
                        @endif
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($PengajuanPkl as $key => $DataPengajuan)
                        @foreach ($Presensi as $key => $DataPresensi)
                        <tr>
                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                            <td>{{ $DataPengajuan->siswa->nm_lengkap }}</td>
                            <td>{{ $DataPengajuan->perusahaan->nm_perusahaan }}</td>
                            <td class="text-center">{{ ucfirst($DataPresensi->status_presensi) }}</td>
                            @if ($DataPresensi->status_presensi === "sakit" || $DataPresensi->status_presensi === "izin")
                                <td class="text-center">{{ $DataPresensi->keterangan }}</td>
                            @endif
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    @if ($DataPresensi->status_presensi === "hadir")
                                    <button type="button" class="btn btn-success me-3" data-bs-toggle="modal" data-bs-target="#FotoMasukModal{{ $DataPresensi->presensiID }}">
                                        Foto Masuk
                                    </button>
                                    <button type="button" class="btn btn-danger me-3" data-bs-toggle="modal" data-bs-target="#FotoPulangModal{{ $DataPresensi->presensiID }}">
                                        Foto Pulang
                                    </button>
                                    <a href="/view/lokasi/siswa/{{ $DataPresensi->nis }}" class="btn btn-primary">Posisi Siswa</a>
                                    @elseif ($DataPresensi->status_presensi === "sakit" || $DataPresensi->status_presensi === "izin")
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#BuktiSuratModal{{ $DataPresensi->presensiID }}">
                                        Bukti Surat
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal code goes here -->
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Include jQuery and DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#myTable').DataTable();
    });

    const selectElement = document.getElementById('mySelect');
    const formElement = document.getElementById('myForm');

    // Tambahkan event listener untuk 'change' pada select
    selectElement.addEventListener('change', function() {
    // Submit form secara otomatis ketika opsi dipilih
    formElement.submit();
    });
</script>
@endsection
