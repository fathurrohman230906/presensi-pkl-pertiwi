@extends('layouts.main')

@section('content')
<!-- Breadcrumb Section -->
<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header">
        <!-- Page Title -->
         <div class="d-flex justify-content-between align-items-center">
             <h4 class="fw-bold pt-2">{{ $title }}</h4>
     
             <a href="{{ route('admin.perusahaan') }}" class="btn btn-danger mt-2 mb-2">keluar</a>
         </div>
    </div>
    <div class="card-body">
        <!-- Create Perusahaan Form -->
        <form action="{{ route('add.perusahaan.admin') }}" method="POST">
            @csrf

            <!-- row 1 -->
            <div class="row">
                <!-- Perusahaan Name (Pendiri) -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pendiri">Pendiri Perusahaan</label>
                        <input type="text" class="form-control @error('pendiri') is-invalid @enderror" id="pendiri" name="pendiri" placeholder="Masukkan Pendiri Perusahaan" value="{{ old('pendiri') }}">
                        @error('pendiri')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Perusahaan Name -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nm_perusahaan">Nama Perusahaan</label>
                        <input type="text" class="form-control @error('nm_perusahaan') is-invalid @enderror" id="nm_perusahaan" name="nm_perusahaan" placeholder="Masukkan Nama Perusahaan" value="{{ old('nm_perusahaan') }}">
                        @error('nm_perusahaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Address -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" placeholder="Masukkan Alamat" value="{{ old('alamat') }}">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan Email Perusahaan" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- row 2 -->
            <div class="row">
                <!-- Deskripsi -->
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-floating">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Leave a comment here" id="deskripsi" name="deskripsi" style="height: 100px">{{ old('deskripsi') }}</textarea>
                            <label for="floatingTextarea2">Deskripsi</label>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- Phone -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_tlp">Nomer Telepon</label>
                        <input type="number" class="form-control @error('no_tlp') is-invalid @enderror" id="no_tlp" name="no_tlp" placeholder="Contoh : 62821...." value="{{ old('no_tlp') }}">
                        @error('no_tlp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <!-- Jurusan -->
                <div class="col-md-6">
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
@endsection
