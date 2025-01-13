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
<!--             <a href="{{ route('create.perusahaan.admin') }}" class="btn btn-success">
    <i class="fas fa-plus-circle me-2"></i> Tambah Perusahaan
</a> -->
            <!-- Button trigger modal -->
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Export
          </button>
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
                    @foreach($dataSiswa as $key => $DataSiswa)
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['nm_lengkap'] }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['jk'] }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['kelas'] }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['tempat_pkl'] }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['agama'] }}</td>
                            <td class="text-center align-middle">{{ $DataSiswa['alamat'] }}</td>
                            <td class="text-center align-middle">
                                @if($DataSiswa['pengajuanID'])
                                    <!-- Edit Button -->
                                <form action="{{ route('edit.admin.siswa') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="pengajuanID" value="{{ $DataSiswa['pengajuanID'] }}">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    </form>
                
                                    <!-- Delete Button -->
                                    <form action="{{ route('delete.perusahaan.admin') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="pengajuanID" value="{{ $DataSiswa['pengajuanID'] }}">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                @else
                                <form action="{{ route('edit.admin.siswa') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="nis" value="{{ $DataSiswa['nis'] }}">
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    </form>
                
                                    <!-- Delete Button -->
                                    <form action="{{ route('delete.perusahaan.admin') }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="nis" value="{{ $DataSiswa['nis'] }}">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Export siswa-->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Export dan Import Data Siswa</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label for="fileExcel" class="form-label">Import File Excel</label>
            <input type="file" name="file" id="fileExcel" class="form-control" accept=".xlsx, .xls, .csv" required>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Import</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="container-fluid">
          <div class="row">
            <div class="col text-start">
              <button type="button" class="btn btn-success">Export</button>
            </div>
            <div class="col text-end">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
            </div>
          </div>
        </div>
      </div>
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
            text: 'jika ingin data ini akan terhapus permanen'
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
