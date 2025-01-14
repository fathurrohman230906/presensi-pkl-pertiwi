@extends('layouts.main')

@section('content')
<!-- Breadcrumb Section -->
<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>

<div class="row me-2">
    <div class="col-md-12 col-lg-12 col-xl-6">
        <div class="card">
            <div class="card-header">
                <!-- Page Title -->
                 <div class="d-flex justify-content-between align-items-center">
                     <h4 class="fw-bold pt-2">{{ $title }}</h4>
             
                     <a href="{{ route('admin.kelas') }}" class="btn btn-danger mt-2 mb-2">keluar</a>
                 </div>
            </div>
            <div class="card-body">
                <!-- Create Perusahaan Form -->
                <form action="{{ route('add.kelas.admin') }}" method="POST">
                    @csrf
        
                    <!-- row 1 -->
                    <div class="row">
                        <!-- Nama Kelas (nm_kelas) -->
                        <div class="col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="nm_kelas">Nama Kelas</label>
                                <input type="text" class="form-control @error('nm_kelas') is-invalid @enderror" id="nm_kelas" name="nm_kelas" placeholder="Masukkan Nama Kelas" value="{{ old('nm_kelas') }}">
                                @error('nm_kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Jurusan -->
                <div class="col-md-12 col-lg-12">
                    <div class="form-group">
                        <label for="jurusan">Jurusan</label>
                        <select class="form-select @error('jurusanID') is-invalid @enderror" id="jurusan" name="jurusanID">
                            <option>Pilih Jurusan</option>
                            @foreach($jurusan as $dataJurusan)
                                <option value="{{ $dataJurusan->jurusanID }}" @if(old('jurusanID') == $dataJurusan->jurusanID) selected @endif>{{ $dataJurusan->nm_jurusan }}</option>
                            @endforeach
                        </select>
                        @error('jurusanID')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Create Perusahaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
