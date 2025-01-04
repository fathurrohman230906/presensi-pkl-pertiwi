@extends('layouts.main')

@section('content')

<h3 class="fw-bold mb-3">Data Siswa</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <!-- Form Filter Perusahaan -->
        {{-- <form action="{{ route('perusahaan.search') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 col-md-8 col-lg-7">
                    <select class="form-select" name="perusahaanID" aria-label="Pilih Perusahaan">
                        <option selected disabled>Pilih Perusahaan</option>
                        @foreach ($Perusahaan as $DataPerusahaan)
                            <option value="{{ $DataPerusahaan->perusahaanID }}"
                                {{ !empty($perusahaanID) && old('perusahaanID', $perusahaanID) == $DataPerusahaan->perusahaanID ? 'selected' : '' }}>
                                {{ $DataPerusahaan->nm_perusahaan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 col-lg-5">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form> --}}

        <!-- Tabel Data Siswa -->
        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama Siswa</th>
                        <th scope="col" class="text-center">Tempat PKL</th>
                        <th scope="col" class="text-center">Periode</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($PengajuanPKL as $key => $DataPkl)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td class="text-center">{{ $DataPkl->siswa->nm_lengkap }}</td>
                                    <td class="text-center">{{ $DataPkl->perusahaan->nm_perusahaan }}</td>
                                    @php
                                    $tanggalMasuk = \Carbon\Carbon::parse($DataPkl->bulan_masuk)->locale('id');
                                    $tanggalKeluar = \Carbon\Carbon::parse($DataPkl->bulan_keluar)->locale('id');
                                    $level = session('level');
                                    @endphp
                                    <td class="text-center">{{ $tanggalMasuk->isoFormat('DD MMMM YYYY') . ' s.d. ' .  $tanggalKeluar->isoFormat('DD MMMM YYYY') }}</td>
                                    <td class="text-center">
                                        <div class="d-flex">
                                            <form action="{{ route('proses.persetujuan.pkl') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="status_pengajuan" value="diterima">
                                                <input type="hidden" name="level" value="{{ $level }}">
                                                <input type="hidden" name="pengajuanID" value="{{ $DataPkl->pengajuanID }}">
                                                <button type="submit" class="btn btn-success me-2"><i class="bi bi-check-circle"></i></button>
                                            </form>
                                            <form action="{{ route('proses.persetujuan.pkl') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="status_pengajuan" value="ditolak">
                                                <input type="hidden" name="level" value="{{ $level }}">
                                                <input type="hidden" name="pengajuanID" value="{{ $DataPkl->pengajuanID }}">
                                                <button type="submit" class="btn btn-danger"><i class="bi bi-x-circle"></i></button>
                                            </form>
                                        </div>
                                    </td>
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
    document.addEventListener('DOMContentLoaded', function () {
        // Konfirmasi Hapus
        window.confirmDelete = function(nis) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${nis}`).submit();
                }
            });
        };

        // Inisialisasi DataTables
        $('#myTable').DataTable();

        // SweetAlert Notifications
        @if (session('peringatan'))
            Swal.fire({
                title: 'Peringatan!',
                text: "{{ session('peringatan') }}",
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        @endif
        
        @if (session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    });
</script>
@endsection
