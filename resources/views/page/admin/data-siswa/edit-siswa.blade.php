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
            <a href="{{ route('admin.siswa') }}" class="btn btn-danger mt-2 mb-2">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Edit Siswa Form -->
        <form action="" method="POST">
            @csrf
            @method('PUT')
            <!-- Row 1 -->
            <div class="row">
                <!-- Nama Siswa -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nm_lengkap">Nama Siswa</label>
                        <input type="text" class="form-control @error('nm_lengkap') is-invalid @enderror" 
                               id="nm_lengkap" name="nm_lengkap" 
                               placeholder="Masukkan Nama Siswa" 
                               value="{{ $dataSiswa->nm_lengkap }}">
                        @error('nm_lengkap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jk">Jenis Kelamin</label>
                        <select class="form-select @error('jk') is-invalid @enderror" id="jk" name="jk">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="L" {{ $dataSiswa->jk == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="P" {{ $dataSiswa->jk == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Row 2 -->
            <div class="row">
                <!-- Alamat -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" name="alamat" 
                                  placeholder="Masukkan Alamat">{{ $dataSiswa->alamat }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Agama -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" class="form-control @error('agama') is-invalid @enderror" 
                               id="agama" name="agama" 
                               placeholder="Masukkan Agama" 
                               value="{{ $dataSiswa->agama }}">
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Update</button>
            </div>
        </form>
    </div>
</div>
@endsection