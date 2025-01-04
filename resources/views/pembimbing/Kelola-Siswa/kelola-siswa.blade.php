@extends('layouts.main')

@section('content')
<style>
    .border-radius {
        border-radius: 10px;
    }
</style>
<h3 class="fw-bold mb-3">Data Siswa</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pembimbing.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Siswa</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <!-- Tabel Data Perusahaan -->
                <!-- Form Filter Perusahaan -->
                <form action="{{ route('search.pembimbing.kelola.siswa') }}" method="post">
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
                </form>
        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama Siswa</th>
                        <th scope="col" class="text-center">Tempat PKL</th>
                        <th scope="col" class="text-center">Jenis Kelamin</th>
                        <th scope="col" class="text-center">Agama</th>
                        <th scope="col" class="text-center">Alamat</th>
                        <th scope="col" class="text-center">Periode</th>
                    </tr>
                </thead>
                {{-- <tbody>
                    @foreach ($siswa as $Datasiswa)
                    <tr>
                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td class="align-middle text-center">{{ $Datasiswa->nm_lengkap }}</td>
                        @php
                            // Filter data PKL untuk siswa ini
                            $DataPkl = $pengajuanPkl->firstWhere('nis', $Datasiswa->nis);
                        @endphp
                        <td class="text-center">
                            @if ($DataPkl)
                                @switch($DataPkl->status_pengajuan)
                                    @case('diterima')
                                        {{ $DataPkl->perusahaan->nm_perusahaan ?? '-' }}
                                        @break
                                    @case('ditunggu')
                                        Menunggu Persetujuan
                                        @break
                                    @default
                                        -
                                @endswitch
                            @else
                                -
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $Datasiswa->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                        <td class="align-middle text-center">{{ $Datasiswa->agama }}</td>
                        <td class="text-center">
                            <span class="short-text">{{ \Illuminate\Support\Str::limit($Datasiswa->alamat, 15) }}</span>
                            <span class="full-text" style="display: none;">{{ $Datasiswa->alamat }}</span>
                            <a href="#" class="toggle-text">Buka</a>
                        </td>
                        <td class="p-2 text-center align-middle">
                            @if ($DataPkl && $DataPkl->status_pengajuan === 'diterima')
                                @php
                                    $tanggalMasuk = \Carbon\Carbon::parse($DataPkl->bulan_masuk)->locale('id');
                                    $tanggalKeluar = \Carbon\Carbon::parse($DataPkl->bulan_keluar)->locale('id');
                                @endphp
                                <span class="short-text">
                                    {{ \Illuminate\Support\Str::limit($tanggalMasuk->isoFormat('DD MMMM YYYY') . ' s.d. ' .  $tanggalKeluar->isoFormat('DD MMMM YYYY'), 15) }}
                                </span>
                                <span class="full-text" style="display: none;">
                                    {{ $tanggalMasuk->isoFormat('DD MMMM YYYY') . ' s.d. ' . $tanggalKeluar->isoFormat('DD MMMM YYYY') }}
                                </span>
                                <a href="#" class="toggle-text">Buka</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
                
                </tbody> --}}
                <tbody>
                    @foreach ($filteredSiswa ?? $siswa as $Datasiswa)
                    <tr>
                        <th scope="row" class="text-center align-middle">{{ $loop->iteration }}</th>
                        <td class="align-middle text-center">{{ $Datasiswa->nm_lengkap }}</td>
                        @php
                            // Filter data PKL untuk siswa ini
                            $DataPkl = $pengajuanPkl->firstWhere('nis', $Datasiswa->nis);
                        @endphp
                        
                        <td class="text-center align-middle">
                            @if ($DataPkl)
                                @switch($DataPkl->status_pengajuan)
                                    @case('diterima')
                                        {{ $DataPkl->perusahaan->nm_perusahaan ?? '-' }}
                                        @break
                                    @case('ditunggu')
                                        <span class="btn btn-warning" title="Menunggu Persetujuan">
                                            <i class="bi bi-hourglass-split"></i>
                                        </span>
                                        @break
                                    @default
                                        -
                                @endswitch
                            @else
                                -
                            @endif
                        </td>

                        <td class="align-middle text-center">{{ $Datasiswa->jk === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                        <td class="align-middle text-center">{{ $Datasiswa->agama }}</td>
                        <td class="text-center">
                            <span class="short-text">{{ \Illuminate\Support\Str::limit($Datasiswa->alamat, 15) }}</span>
                            <span class="full-text" style="display: none;">{{ $Datasiswa->alamat }}</span>
                            <a href="#" class="toggle-text">Buka</a>
                        </td>
                        <td class="p-2 text-center align-middle">
                            @if ($DataPkl && $DataPkl->status_pengajuan === 'diterima')
                                @php
                                    $tanggalMasuk = \Carbon\Carbon::parse($DataPkl->bulan_masuk)->locale('id');
                                    $tanggalKeluar = \Carbon\Carbon::parse($DataPkl->bulan_keluar)->locale('id');
                                @endphp
                                <span class="short-text">
                                    {{ \Illuminate\Support\Str::limit($tanggalMasuk->isoFormat('DD MMMM YYYY') . ' s.d. ' .  $tanggalKeluar->isoFormat('DD MMMM YYYY'), 15) }}
                                </span>
                                <span class="full-text" style="display: none;">
                                    {{ $tanggalMasuk->isoFormat('DD MMMM YYYY') . ' s.d. ' . $tanggalKeluar->isoFormat('DD MMMM YYYY') }}
                                </span>
                                <a href="#" class="toggle-text">Buka</a>
                            @else
                                -
                            @endif
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
        document.querySelectorAll('.toggle-text').forEach(function (element) {
            element.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah link dari melakukan navigasi
                const parent = this.closest('td');
                const shortText = parent.querySelector('.short-text');
                const fullText = parent.querySelector('.full-text');
    
                // Tampilkan atau sembunyikan teks
                if (fullText.style.display === "none") {
                    fullText.style.display = "inline";
                    shortText.style.display = "none";
                    this.textContent = "Tutup";
                } else {
                    fullText.style.display = "none";
                    shortText.style.display = "inline";
                    this.textContent = "Buka";
                }
            });
        });
        // // Konfirmasi Hapus
        // window.confirmDelete = function(perusahaanID) {
        //     Swal.fire({
        //         title: 'Yakin ingin menghapus?',
        //         text: "Data aktivitas siswa dan data pengajuan pkl yang sudah di terima akan terbawa ke hapus secara permanen!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Ya, hapus!',
        //         cancelButtonText: 'Batal'
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             document.getElementById(`deleteForm-${perusahaanID}`).submit();
        //         }
        //     });
        // };

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
