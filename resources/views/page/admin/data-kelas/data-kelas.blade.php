@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

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
            <a href="{{ route('create.kelas.admin') }}" class="btn btn-success">
    <i class="fas fa-plus-circle me-2"></i> Tambah Data
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
                        <th class="text-center align-middle">Nama Kelas</th>
                        <th class="text-center align-middle">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Kelas as $key => $DataKelas)
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">{{ $DataKelas['nm_kelas'] }}</td>
                            <td class="text-center align-middle">
                                <form action="{{ route('edit.kelas.admin') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="kelasID" value="{{ $DataKelas['kelasID'] }}">
                                    <button type="submit" class="btn btn-warning mb-2">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    </form>
                
                                    <!-- Delete Button -->
                                    <form action="{{ route('delete.kelas.admin') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="kelasID" value="{{ $DataKelas['kelasID'] }}">
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete(this)">
                                            <i class="fas fa-trash-alt"></i>
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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if (session('success'))
        Swal.fire({
            title: 'Sukses!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    @endif
    @if (session('error'))
        Swal.fire({
            title: 'Peringatan!',
            text: "{{ session('error') }}",
            icon: 'info',
            confirmButtonText: 'OK'
        });
    @endif
});
    // Confirm before deleting
    function confirmDelete(button) {
    Swal.fire({
        title: 'Apakah ingin hapus data ini?',
        text: 'Data ini akan terhapus permanen!',
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
</script>

@endsection
