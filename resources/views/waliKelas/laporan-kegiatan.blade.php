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

<h3 class="fw-bold mb-3">{{ $titlePage }}</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $titlePage }}</li>
    </ol>
</nav>

<div class="card mt-3">
    <div class="card-body">
        <form action="{{ route('data.laporan.search') }}" method="post" class="p-2 mb-3">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8 col-lg-4">
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
                        <th scope="col" class="text-center">Kegiatan Siswa</th>
                        <th scope="col" class="text-center">Tanggal Kegiatan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $groupedKegiatanPKL = [];
                    foreach ($KegiatanPKL as $DataKegiatanPKL) {
                        // Pastikan perusahaan ada sebelum menambahkan data ke array
                        $perusahaan = $pengajuanPklByNis[$DataKegiatanPKL->nis]->perusahaan->nm_perusahaan ?? null;
                        
                        // Hanya tambahkan data jika perusahaan ada
                        if ($perusahaan) {
                            $key = $DataKegiatanPKL->nis . '-' . $DataKegiatanPKL->tgl_kegiatan;
                            if (!isset($groupedKegiatanPKL[$key])) {
                                $groupedKegiatanPKL[$key] = [
                                    'siswa' => $DataKegiatanPKL->siswa->nm_lengkap,
                                    'perusahaan' => $perusahaan,
                                    'deskripsi_kegiatan' => ucfirst($DataKegiatanPKL->deskripsi_kegiatan),
                                    'tgl_kegiatan' => $DataKegiatanPKL->tgl_kegiatan
                                ];
                            } else {
                                // Gabungkan deskripsi jika sudah ada entri
                                $groupedKegiatanPKL[$key]['deskripsi_kegiatan'] .= ', ' . ucfirst($DataKegiatanPKL->deskripsi_kegiatan);
                            }
                        }
                    }
                @endphp
                
                @foreach ($groupedKegiatanPKL as $key => $data)
                    <tr>
                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td>{{ $data['siswa'] }}</td>
                        <td>{{ $data['perusahaan'] }}</td>
                        <td class="text-center">{{ $data['deskripsi_kegiatan'] }}</td>
                        {{-- <td class="text-center">{{ \Carbon\Carbon::parse($data['tgl_kegiatan'])->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td> --}}
                        <td class="text-center">{{ \Carbon\Carbon::parse($data['tgl_kegiatan'])->format('d-m-Y') }}</td>
                    </tr>
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