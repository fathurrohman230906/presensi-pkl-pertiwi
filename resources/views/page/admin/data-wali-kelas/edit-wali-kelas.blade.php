@extends('layouts.main')

@section('content')
<!-- Breadcrumb Section -->
<nav aria-label="breadcrumb" class="mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin-dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
    </ol>
</nav>

<div class="card mb-2">
    <div class="card-header">
        <!-- Page Title -->
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold pt-2">{{ $title }}</h4>
            <a href="{{ route('admin.wali.kelas') }}" class="btn btn-danger mt-2 mb-2">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Edit Siswa Form -->
        <form action="{{ route('update.admin.waliKelas') }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="wali_kelasID" value="{{ $WaliKelas->wali_kelasID }}">
              <!-- Row 1 -->
              <div class="row">
                  <!-- Nama Siswa -->
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="nm_lengkap">Nama Wali Kelas</label>
                          <input type="text" class="form-control @error('nm_lengkap') is-invalid @enderror" 
                                 id="nm_lengkap" name="nm_lengkap" 
                                 placeholder="Masukkan Nama Siswa" 
                                 value="{{ old('nm_lengkap', $WaliKelas->nm_lengkap) }}">
                          @error('nm_lengkap')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <!-- Kelas -->
                  <div class="col-md-6">
    <div class="form-group">
        <label for="kelasID">Kelas</label>
        <select class="form-select @error('kelasID') is-invalid @enderror" id="kelasID" name="kelasID">
            <option value="" disabled {{ old('kelasID', $WaliKelas->kelasID) == '' ? 'selected' : '' }}>Pilih Kelas Siswa</option>
            @foreach($DaftarKelas as $kelas)
                <option value="{{ $kelas->kelasID }}" 
                    {{ old('kelasID', $WaliKelas->kelasID) == $kelas->kelasID ? 'selected' : '' }}>
                    {{ $kelas->nm_kelas }}
                </option>
            @endforeach
        </select>
        @error('kelasID')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
                  <!-- Jenis Kelamin -->
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="jk">Jenis Kelamin</label>
                          <select class="form-select @error('jk') is-invalid @enderror" id="jk" name="jk">
                              <option value="" disabled {{ old('jk', $WaliKelas->jk) == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                              <option value="L" {{ old('jk', $WaliKelas->jk) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                              <option value="P" {{ old('jk', $WaliKelas->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                                    placeholder="Masukkan Alamat">{{ old('alamat', $WaliKelas->alamat) }}</textarea>
                          @error('alamat')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
  
                  <!-- Agama -->
                  <div class="col-md-6">
    <div class="form-group">
        <label for="agama">Agama</label>
        <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama">
            <option value="" disabled {{ strtolower(old('agama', $WaliKelas->agama)) == '' ? 'selected' : '' }}>Pilih Agama</option>
            <option value="Islam" {{ strtolower(old('agama', $WaliKelas->agama)) == 'islam' ? 'selected' : '' }}>Islam</option>
            <option value="Kristen" {{ strtolower(old('agama', $WaliKelas->agama)) == 'kristen' ? 'selected' : '' }}>Kristen</option>
            <option value="Katolik" {{ strtolower(old('agama', $WaliKelas->agama)) == 'katolik' ? 'selected' : '' }}>Katolik</option>
            <option value="Hindu" {{ strtolower(old('agama', $WaliKelas->agama)) == 'hindu' ? 'selected' : '' }}>Hindu</option>
            <option value="Buddha" {{ strtolower(old('agama', $WaliKelas->agama)) == 'buddha' ? 'selected' : '' }}>Buddha</option>
            <option value="Konghucu" {{ strtolower(old('agama', $WaliKelas->agama)) == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
        </select>
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