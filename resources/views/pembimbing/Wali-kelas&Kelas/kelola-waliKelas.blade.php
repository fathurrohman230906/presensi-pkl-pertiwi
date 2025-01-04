@extends('layouts.main')

@section('content')

<h3 class="fw-bold mb-3">Data Wali Kelas</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Wali Kelas</li>
    </ol>
</nav>

<div class="card">
    <div class="card-body">
        <!-- Tabel Data Siswa -->
        <div class="table-responsive mt-3">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Nama Wali Kelas</th>
                        <th scope="col" class="text-center">Kelas</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($waliKelas as $key => $DatawaliKelas)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td class="text-center">{{ $DatawaliKelas->nm_lengkap }}</td>
                                    <td class="text-center">{{ $DatawaliKelas->kelas->nm_kelas }}</td>
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
