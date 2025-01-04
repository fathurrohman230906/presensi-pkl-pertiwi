@extends('layouts.main')

@section('content')
<style>
    .btn-center {
        display: flex;
        justify-content: center;
    }
</style>

<h3 class="fw-bold mb-3">Data Kelas</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Kelas</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <!-- Button Tambah Kelas -->
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#TambahKelas">
            Tambah Kelas
        </button>
        <!-- Tabel Data Siswa -->
        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Kelas</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($kelas as $key => $Datakelas)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td class="text-center">{{ $Datakelas->nm_kelas }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-danger" href="{{ route('hapus.kelas.pembimbing', ['kelasID' => $Datakelas->kelasID]) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>                                    
                                </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

  <!-- Modal Tambah Kelas -->
  <div class="modal fade" id="TambahKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kelas</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="{{ route('kelola.kelas.create') }}" method="post">
            @csrf
            <input type="hidden" class="form-control" name="jurusanID" value="{{ $jurusanID }}">
            {{-- <div class="form-floating mb-3">
                <input type="text" class="form-control" name="nm_kelas" id="floatingInput">
                <label for="floatingInput">Kelas Baru</label>
            </div> --}}
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Kelas Baru</label>
                <input type="text" class="form-control" id="exampleFormControlInput1" name="nm_kelas" placeholder="Masukkan nama kelas contoh : XII RPL 2">
              </div>

            <div class="btn-center">
                <button type="submit" class="btn btn-success">
                    <span class="p-5">Save</span>
                </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<!-- Include jQuery and DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {

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
