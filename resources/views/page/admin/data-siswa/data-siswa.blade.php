@extends('layouts.main')

@section('content')
<!-- Make sure jQuery is loaded before DataTables CSS and JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="/DataTables/datatables.css" /> <!-- Ensure correct path -->

<!-- Optional: Additional Styling for Button Hover Effect -->
<style>
    .btn-sm {
        margin-right: 5px;
    }
</style>

<!-- Breadcrumb Section -->
<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $titlePage }}</li>
    </ol>
</nav>

<!-- Page Title -->
<h3 class="fw-bold mb-4">{{ $titlePage }}</h3>

<div class="card">
    <div class="card-header">
        <!-- Add Button -->
        <div class="my-2">
            <a href="{{ route('create.perusahaan.admin') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i> Tambah Perusahaan
            </a>
        </div>
    </div>

    <div class="card-body">
        <!-- DataTable Section -->
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered shadow-sm rounded" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Nama Siswa</th>
                        <th class="text-center align-middle">Jenis Kelamin</th>
                        <th class="text-center align-middle">Kelas</th>
                        <th class="text-center align-middle">Tempat PKL</th>
                        <th class="text-center align-middle">Agama</th>
                        <th class="text-center align-middle">Alamat</th>
                        <th class="text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $DataSiswa)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa->nm_siswa }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa->jk }}</td>
                            @foreach($DataSiswa->kelas as $kelas)
    <td class="text-center align-middle">{{ $kelas->nm_kelas }}</td>
@endforeach

                            <!-- @foreach($DataSiswa->perusahaan as $perusahaan)
                            <td class="text-center align-middle">{{ $perusahaan->nm_perusahaan }}</td>
                            @endforeach -->
                            <td class="text-center align-middle">{{ $DataSiswa->agama }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa->alamat }}</td>
                            <td class="text-center align-middle">
                                <!-- Edit Button -->
                                <a href="{{ route('edit.perusahaan.admin', ['perusahaanID' => $item->perusahaanID]) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('delete.perusahaan.admin') }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="perusahaanID" value="{{ $item->perusahaanID }}">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables JS and Initialization -->
<script src="/DataTables/datatables.js"></script>
<script>
    // Confirm before deleting
    function confirmDelete(button) {
        Swal.fire({
            title: 'Apakah ingin hapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, Hapus',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    // Initialize DataTable once the document is ready
    $(document).ready(function() {
        $('#myTable').DataTable(); // Initializes DataTable
    });

    // SweetAlert success notification
    document.addEventListener('DOMContentLoaded', function () {
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
