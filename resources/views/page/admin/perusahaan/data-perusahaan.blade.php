@extends('layouts.main')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<link rel="stylesheet" href="/DataTables/datatables.css" /> 
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
                        <th class="text-center align-middle">Pendiri</th>
                        <th class="text-center align-middle">Nama Perusahaan</th>
                        <th class="text-center align-middle">Email</th>
                        <th class="text-center align-middle">No Telepon</th>
                        <th class="text-center align-middle">Deskripsi</th>
                        <th class="text-center align-middle">Alamat</th>
                        <th class="text-center align-middle">Jurusan</th>
                        <th class="text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perusahaan as $item)
                        <tr>
                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                            <td class="text-center align-middle">{{ $item->pendiri }}</td>
                            <td class="text-center align-middle">{{ $item->nm_perusahaan }}</td>
                            <td class="text-center align-middle">{{ $item->email }}</td>
                            <td class="text-center align-middle">{{ $item->no_tlp }}</td>
                            <td class="text-center align-middle">{{ $item->deskripsi }}</td>
                            <td class="text-center align-middle">{{ $item->alamat }}</td>
                            <td class="text-center align-middle">{{ $item->jurusan->nm_jurusan }}</td>
                            <td class="text-center align-middle">
                                <!-- Edit Button -->
                                <form action="{{ route('edit.perusahaan.admin') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="perusahaanID" value="{{ $item->perusahaanID }}">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                </form>
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

<script src="/DataTables/datatables.js"></script>
<script>
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
                // If confirmed, submit the form
                button.closest('form').submit();
            }
        });
    }
    // Pastikan DataTables diinisialisasi setelah halaman dimuat
    $(document).ready(function() {
        let table = new DataTable('#myTable');
    });

    document.addEventListener('DOMContentLoaded', function () {

    @if (session('success'))
        console.log('SweetAlert Success Aktif');
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
