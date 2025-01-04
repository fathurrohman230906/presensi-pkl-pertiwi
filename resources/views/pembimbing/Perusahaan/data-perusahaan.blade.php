@extends('layouts.main')

@section('content')
<style>
    .short-text {
    display: inline;
}

.full-text {
    display: none;
}

</style>
<h3 class="fw-bold mb-3">Data Perusahaan</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pembimbing.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Perusahaan</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <a href="{{ route('pembimbing.perusahaan.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Perusahaan
        </a>
        
        {{-- <a href="{{ route('pembimbing.perusahaan.create') }}" class="btn btn-success">Tambah Perusahaan</a> --}}
        <!-- Tabel Data Perusahaan -->
        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Pendiri Perusahaan</th>
                        <th scope="col" class="text-center">Nama Perusahaan</th>
                        <th scope="col" class="text-center">Email</th>
                        <th scope="col" class="text-center">Nomer Telepon</th>
                        <th scope="col" class="text-center">Alamat</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($Perusahaan as $key => $DataPerusahaan)
                                <tr>
                                    {{-- <th scope="row" class="text-center">{{ $loop->iteration }}</th> --}}
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td class="text-center">{{ $DataPerusahaan->pendiri }}</td>
                                    <td class="text-center">{{ $DataPerusahaan->nm_perusahaan }}</td>
                                    <td class="text-center">{{ $DataPerusahaan->email }}</td>
                                    <td class="text-center">{{ $DataPerusahaan->no_tlp }}</td>
                                    <td class="text-center">
                                        <span class="short-text">{{ \Illuminate\Support\Str::limit($DataPerusahaan->alamat, 10) }}</span>
                                        <span class="full-text" style="display: none;">{{ $DataPerusahaan->alamat }}</span>
                                        <a href="#" class="toggle-text">Buka</a>
                                    </td>
                                    
                                    {{-- <td class="text-center">{{ $DataPerusahaan->alamat }}</td> --}}
                                    <td class="text-center">
                                        <div class="d-flex">
                                            <form id="editForm-{{ $DataPerusahaan->perusahaanID }}" action="{{ route('pembimbing.perusahaan.edit') }}" method="POST" style="display: inline;">
                                                @csrf
                                                <input type="hidden" name="perusahaanID" value="{{ $DataPerusahaan->perusahaanID }}">
                                                <button type="submit" class="btn btn-warning me-2"><i class="fas fa-pencil"></i></button>
                                            </form>
                                            
                                            <form id="deleteForm-{{ $DataPerusahaan->perusahaanID }}" action="{{ route('pembimbing.perusahaan.delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="perusahaanID" value="{{ $DataPerusahaan->perusahaanID }}">
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete('{{ $DataPerusahaan->perusahaanID }}')"><i class="bi bi-trash"></i></button>
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
    // document.addEventListener("DOMContentLoaded", function () {
    // });
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
        // Konfirmasi Hapus
        window.confirmDelete = function(perusahaanID) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data aktivitas siswa dan data pengajuan pkl yang sudah di terima akan terbawa ke hapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`deleteForm-${perusahaanID}`).submit();
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
