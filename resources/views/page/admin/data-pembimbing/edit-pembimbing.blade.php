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
            <a href="{{ route('admin.pembimbing') }}" class="btn btn-danger mt-2 mb-2">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <!-- Edit Siswa Form -->
        <form action="{{ route('update.admin.pembimbing') }}" method="POST">
            @csrf
            @method('PUT')
            
            <input type="hidden" name="pembimbingID" value="{{ $Pembimbing->pembimbingID }}">
              <!-- Row 1 -->
              <div class="row">
                  <!-- Nama Lengkap -->
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="nm_lengkap">Nama Pembimbing</label>
                          <input type="text" class="form-control @error('nm_lengkap') is-invalid @enderror" 
                                 id="nm_lengkap" name="nm_lengkap" 
                                 placeholder="Masukkan Nama Pembimbing" 
                                 value="{{ old('nm_lengkap', $Pembimbing->nm_lengkap) }}">
                          @error('nm_lengkap')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <!-- Jurusan -->
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="jurusanID">Kelas</label>
                        <select class="form-select @error('jurusanID') is-invalid @enderror" id="jurusanID" name="jurusanID">
                            <option value="" disabled {{ old('jurusanID', $Pembimbing->jurusanID) == '' ? 'selected' : '' }}>Pilih Kelas Siswa</option>
                            @foreach($DaftarJurusan as $DataJurusan)
                                <option value="{{ $DataJurusan->jurusanID }}" 
                                    {{ old('jurusanID', $Pembimbing->jurusanID) == $DataJurusan->jurusanID ? 'selected' : '' }}>
                                    {{ $DataJurusan->nm_jurusan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jurusanID')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                  <!-- Jenis Kelamin -->
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="jk">Jenis Kelamin</label>
                          <select class="form-select @error('jk') is-invalid @enderror" id="jk" name="jk">
                              <option value="" disabled {{ old('jk', $Pembimbing->jk) == '' ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                              <option value="L" {{ old('jk', $Pembimbing->jk) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                              <option value="P" {{ old('jk', $Pembimbing->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                          </select>
                          @error('jk')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                <!-- Level -->
                <div class="col-md-6">
                      <div class="form-group">
                          <label for="level">Jabatan</label>
                          <select class="form-select @error('level') is-invalid @enderror" id="level" name="level">
                              <option value="" disabled {{ old('level', $Pembimbing->level) == '' ? 'selected' : '' }}>Pilih Jabatan</option>
                              <option value="kepala program" {{ old('level', $Pembimbing->level) == 'kepala program' ? 'selected' : '' }}>Kepala Program</option>
                              <option value="pembimbing" {{ old('level', $Pembimbing->level) == 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                          </select>
                          @error('level')
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
                                    placeholder="Masukkan Alamat">{{ old('alamat', $Pembimbing->alamat) }}</textarea>
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
                            <option value="" disabled {{ strtolower(old('agama', $Pembimbing->agama)) == '' ? 'selected' : '' }}>Pilih Agama</option>
                            <option value="Islam" {{ strtolower(old('agama', $Pembimbing->agama)) == 'islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ strtolower(old('agama', $Pembimbing->agama)) == 'kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ strtolower(old('agama', $Pembimbing->agama)) == 'katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ strtolower(old('agama', $Pembimbing->agama)) == 'hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ strtolower(old('agama', $Pembimbing->agama)) == 'buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ strtolower(old('agama', $Pembimbing->agama)) == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
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