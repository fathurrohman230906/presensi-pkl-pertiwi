{{-- @extends('layouts.main')
@section('content')
<style>
    .breadcrumb {
        border: none;
    }
    .modal-content img {
        max-width: 100%;
        height: auto;
    }
</style>

<h3 class="fw-bold mb-3">Kelola Presensi</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Presensi</li>
    </ol>
</nav>

<div class="card mt-3">
    <div class="card-body">
        <form action="{{ route('internship.kelola.presensi.search') }}" method="post" class="p-2 mb-3">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8 col-lg-4">
                    <select class="form-select" name="nis" aria-label="Pilih Perusahaan">
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
    
                <div class="col-12 col-md-8 col-lg-4">
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
                            
    
                <div class="col-12 col-md-4 col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
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
                    @foreach ($Presensi as $key => $DataPresensi)
                    <tr>
                        <th scope="row" class="text-center">{{ $key + 1 }}</th>
                        <td>{{ $DataPresensi->siswa->nm_lengkap }}</td>
                        <td>{{ $DataPresensi->perusahaan->nm_perusahaan }}</td>
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
                                    <a href="/internship-view/lokasi/siswa/{{ $DataPresensi->nis }}" class="btn btn-primary">Posisi Siswa</a>
                                @elseif ($DataPresensi->status_presensi === "sakit" || $DataPresensi->status_presensi === "izin")
                                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#BuktiSuratModal{{ $DataPresensi->presensiID }}">
                                        Bukti Surat
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
        
                    <!-- Modal to display the photo for 'Masuk' -->
                    <div class="modal fade" id="FotoMasukModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="FotoMasukModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="FotoMasukModalLabel">Foto Masuk - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card text-bg-dark">
                                        <img src="{{ asset('storage/FotoPresensi/Masuk/' . $DataPresensi->foto) }}" alt="Presensi Photo" class="card-img">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end text-end">
                                            <div class="d-flex justify-content-end text-end">
                                                <p class="card-text me-2"><small>{{ \Carbon\Carbon::parse($DataPresensi->masuk)->format('H : i : s') }}</small></p>
                                                <p class="card-text"><small>{{ \Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d-m-Y') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Modal for 'Pulang' photo -->
                    <div class="modal fade" id="FotoPulangModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="FotoPulangModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="FotoPulangModalLabel">Foto Pulang - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card text-bg-dark">
                                        <img src="{{ asset('storage/FotoPresensi/Pulang/' . $DataPresensi->foto_pulang) }}" alt="Presensi Photo" class="card-img">
                                        <div class="card-img-overlay d-flex flex-column justify-content-end text-end">
                                            <div class="d-flex justify-content-end text-end">
                                                <p class="card-text me-2"><small>{{ \Carbon\Carbon::parse($DataPresensi->pulang)->format('H : i : s') }}</small></p>
                                                <p class="card-text"><small>{{ \Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d-m-Y') }}</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <!-- Modal for 'Bukti Surat' -->
                    <div class="modal fade" id="BuktiSuratModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="BuktiSuratModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="BuktiSuratModalLabel">Bukti Surat - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="card text-bg-dark">
                                        <img src="{{ asset('storage/bukti_surat/' . $DataPresensi->foto) }}" alt="Presensi Photo" class="card-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
</script>    
@endsection --}}
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
</style>

<h3 class="fw-bold mb-3">Kelola Presensi</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Presensi</li>
    </ol>
</nav>

<div class="card mt-3">
    <div class="card-body">
        {{-- <form action="{{ route('kelola.presensi.search') }}" method="post" class="p-2 mb-3"> --}}
        <form action="{{ route('internship.kelola.presensi.search') }}" method="post" class="p-2 mb-3">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8 col-lg-4">
                    <select class="form-select" name="nis" aria-label="Pilih Perusahaan">
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
    
                <div class="col-12 col-md-8 col-lg-4">
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
                            
    
                <div class="col-12 col-md-4 col-lg-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
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
                        
                        <!-- Modal to display the photo for 'Masuk' -->
                        <div class="modal fade" id="FotoMasukModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="FotoMasukModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="FotoMasukModalLabel">Foto Masuk - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card text-bg-dark">
                                            <img src="{{ asset('storage/FotoPresensi/Masuk/' . $DataPresensi->foto) }}" alt="Presensi Photo" class="card-img">
                                            <div class="card-img-overlay d-flex flex-column justify-content-end text-end">
                                                <div class="d-flex justify-content-end text-end">
                                                    <p class="card-text me-2"><small>{{ \Carbon\Carbon::parse($DataPresensi->masuk)->format('H : i : s') }}</small></p>
                                                    <p class="card-text"><small>{{ \Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d-m-Y') }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Modal for 'Pulang' photo -->
                        <div class="modal fade" id="FotoPulangModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="FotoPulangModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="FotoPulangModalLabel">Foto Pulang - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card text-bg-dark">
                                            <img src="{{ asset('storage/FotoPresensi/Pulang/' . $DataPresensi->foto_pulang) }}" alt="Presensi Photo" class="card-img">
                                            <div class="card-img-overlay d-flex flex-column justify-content-end text-end">
                                                <div class="d-flex justify-content-end text-end">
                                                    <p class="card-text me-2"><small>{{ \Carbon\Carbon::parse($DataPresensi->pulang)->format('H : i : s') }}</small></p>
                                                    <p class="card-text"><small>{{ \Carbon\Carbon::parse($DataPresensi->tgl_presensi)->format('d-m-Y') }}</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Modal for 'Bukti Surat' -->
                        <div class="modal fade" id="BuktiSuratModal{{ $DataPresensi->presensiID }}" tabindex="-1" aria-labelledby="BuktiSuratModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="BuktiSuratModalLabel">Bukti Surat - {{ $DataPresensi->siswa->nm_lengkap }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card text-bg-dark">
                                            <img src="{{ asset('storage/bukti_surat/' . $DataPresensi->foto) }}" alt="Presensi Photo" class="card-img">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
</script>    
@endsection