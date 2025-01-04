@extends('layouts.main')

@section('content')
<h3 class="fw-bold mb-3">{{ $titlePage }}</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $titlePage }}</li>
    </ol>
</nav>

<div class="card card-default card-profile">
  {{-- <img class="card-header-bg img-card-header" src="{{ asset('storage/FotoProfile/User/fTI1pcaAzKO4GCbyWAC5DzBDD5saW87lVr5VeB2F.jpg') }}" alt="Foto User"> --}}
  
    <div class="card-body card-profile-body">
      @php
          $role = session('role');
          if($role === "admin") {
            $directoryfoto = 'Admin';
          } elseif ($role === "pembimbing") {
            $directoryfoto = 'Pembimbing';
          } elseif ($role === "wali_kelas") {
            $directoryfoto = 'WaliKelas';
          }
      @endphp
      <div class="profile-avata">
        <img src="{{ $DataUser->foto ? asset('storage/FotoProfile/' . $directoryfoto . '/' . $DataUser->foto) : asset('assets/images/user/u-xl-11.jpg') }}" class="rounded-circle img-user" alt="Avata Image" />
        <span class="h5 d-block mt-3 mb-2">{{ $DataUser->nm_lengkap }}</span>
        <span class="d-block">{{ $DataUser->email }}</span>
      </div>
    </div>
  
    <div class="card-footer card-profile-footer">
      <ul class="nav nav-border-top justify-content-center">
        <li class="nav-item">
          <a class="nav-link active" id="ProfileTab" href="#ProfileContent">Detail Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="EditProfileTab" href="#EditProfileContent">Edit Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="LupaPasswordTab" href="#LupaPasswordContent">Lupa Password</a>
        </li>
      </ul>
    </div>
  
</div>

<!-- Tab Content -->
<div class="tab-content">
  {{-- Detail Profile --}}
  <div class="tab-pane fade show active" id="ProfileContent">
    <div class="row">
      <div class="col-12">
        <div class="card card-default">
          <div class="card-header">
            <h2>Detail Profile</h2>
          </div>
          <div class="card-body">
            <!-- Profile Content Here -->
              <div class="row">
                @foreach($fillable as $field)
                    @if($field !== 'password' && $field !== 'foto') <!-- Exclude password and foto fields -->
                        <div class="col-md-6 mb-3">
                            <label for="{{ $field }}" class="form-label">{{ $customLabels[$field] ?? ucwords(str_replace('_', ' ', $field)) }}</label>

                            <!-- Handle specific fields differently -->
                            @if($field == 'kelasID' && isset($relatedData['kelas'])) 
                                <!-- Show related Kelas name -->
                                <input type="text" class="form-control" id="{{ $field }}" value="{{ $relatedData['kelas'] }}" readonly>
                            @elseif($field == 'jurusanID' && isset($relatedData['jurusan']))
                                <!-- Show related Jurusan name -->
                                <input type="text" class="form-control" id="{{ $field }}" value="{{ $relatedData['jurusan'] }}" readonly>
                            @elseif($field == 'email')
                                <!-- Email field (readonly) -->
                                <input type="email" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ $DataUser->$field }}" readonly>
                            @elseif($field == 'jk')
                                <!-- Gender field (Laki-Laki / Perempuan) -->
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="@if ($DataUser->$field === 'L'){{ "Laki-Laki" }}
                                @elseif ($DataUser->$field === 'P'){{ "Perempuan" }}@endif" readonly>
                            @elseif($field == 'no_tlp')
                                <!-- Phone number field (formatted) -->
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ $DataUser->$field }}" readonly>
                            @else
                                <!-- General text input for other fields -->
                                <input type="text" class="form-control" id="{{ $field }}" name="{{ $field }}" value="{{ $DataUser->$field }}" readonly>
                            @endif
                        </div>
                    @endif
                @endforeach

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- Edit Profile --}}
<!-- Edit Profile Tab -->
<div class="tab-pane fade" id="EditProfileContent">
  <div class="row">
      <div class="col-12">
          <div class="card card-default">
              <div class="card-header">
                  <h2>Edit Profile</h2>
              </div>
              <div class="card-body">
                  <!-- Form Edit Profile -->
                  <form action="{{ route('edit.profile.user') }}" method="post" enctype="multipart/form-data">
                      @csrf
                      <!-- Pastikan untuk mengirim role jika diperlukan -->
                      <input type="hidden" name="role" value="{{ session('role') }}">
                      
                      <div class="row">
                          <!-- Nama Lengkap -->
                          <div class="col-md-6 mb-3">
                              <label for="nm_lengkap" class="form-label">Nama Lengkap</label>
                              <input type="text" name="nm_lengkap" class="form-control" id="nm_lengkap" value="{{ old('nm_lengkap', $DataUser->nm_lengkap) }}">
                              @error('nm_lengkap')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>

                          <!-- Jenis Kelamin -->
                          <div class="col-md-6 mb-3">
                              <label for="jk" class="form-label">Jenis Kelamin</label>
                              <select class="form-select" id="jk" name="jk">
                                  <option value="L" {{ old('jk', $DataUser->jk) == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                  <option value="P" {{ old('jk', $DataUser->jk) == 'P' ? 'selected' : '' }}>Perempuan</option>
                              </select>
                              @error('jk')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>

                          <!-- Agama -->
                          <div class="col-md-6 mb-3">
                              <label for="agama" class="form-label">Agama</label>
                              <select class="form-select" id="agama" name="agama">
                                  <option value="Islam" {{ old('agama', $DataUser->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                                  <option value="Kristen" {{ old('agama', $DataUser->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                  <option value="Katolik" {{ old('agama', $DataUser->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                  <option value="Hindu" {{ old('agama', $DataUser->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                  <option value="Buddha" {{ old('agama', $DataUser->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                  <option value="Konghucu" {{ old('agama', $DataUser->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                  <option value="Lainnya" {{ old('agama', $DataUser->agama) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                              </select>
                              @error('agama')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>

                          <!-- No Telp -->
                          <div class="col-md-6 mb-3">
                              <label for="no_tlp" class="form-label">Nomor Telepon</label>
                              <input type="text" name="no_tlp" class="form-control" id="no_tlp" value="{{ old('no_tlp', $no_tlp) }}">
                              @error('no_tlp')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>

                          <!-- Alamat -->
                          <div class="col-md-6 mb-3">
                              <label for="alamat" class="form-label">Alamat</label>
                              <textarea class="form-control" name="alamat" id="alamat" rows="3">{{ old('alamat', $DataUser->alamat) }}</textarea>
                              {{-- <input type="text" name="alamat" class="form-control" id="alamat" value="{{ old('alamat', $DataUser->alamat) }}"> --}}
                              @error('alamat')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>

                          <!-- Foto Profile -->
                          <div class="col-md-6 mb-3">
                              <label for="foto" class="form-label">Foto Profil</label>
                              <input type="file" class="form-control" id="foto" name="foto">
                              <small>Format: jpeg, png, jpg, gif</small>
                              @error('foto')
                                  <div class="text-danger">{{ $message }}</div>
                              @enderror
                          </div>
                          
                      </div>

                      <!-- Tombol Submit -->
                      <button type="submit" class="btn btn-warning"><i class="bi bi-pencil me-2"></i>Edit Profile</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>

  
  <div class="tab-pane fade" id="LupaPasswordContent">
    <div class="row">
      <div class="col-12">
        <div class="card card-default">
          <div class="card-header">
            <h2>Lupa Password</h2>
          </div>
          <div class="card-body">
            <!-- Lupa Password Content Here -->
            <form action="{{ route('edit.password.user') }}" method="post">
              @csrf
              <!-- Pastikan untuk mengirim role jika diperlukan -->
              <input type="hidden" name="role" value="{{ session('role') }}">
              
              <div class="row">
                <!-- Password Baru -->
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" id="password">
                  @error('password')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <!-- Konfirmasi Password -->
                <div class="col-md-6 mb-3">
                  <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                  <input type="password" name="konfirmasi_password" class="form-control" id="konfirmasi_password">
                  @error('konfirmasi_password')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>

                <div class="form-check ms-3 mb-3">
                  <input class="form-check-input" type="checkbox" id="togglePassword">
                  <label class="form-check-label" for="togglePassword">
                      Lihat Password
                  </label>
                </div>
              </div>
              <!-- Tombol Submit -->
              <button type="submit" class="btn btn-warning"><i class="bi bi-pencil me-2"></i>Reset Password</button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include jQuery and DataTables JS & CSS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        $('#myTable').DataTable();

        // Tab functionality
        $('.nav-link').click(function(e) {
            e.preventDefault(); // Prevent the default link behavior

            // Remove active class from all tabs
            $('.nav-link').removeClass('active');

            // Add active class to the clicked tab
            $(this).addClass('active');

            // Hide all tab content
            $('.tab-pane').removeClass('show active');

            // Show the content of the clicked tab
            var target = $(this).attr('href');
            $(target).addClass('show active');
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    @if (session('peringatan'))
        console.log('SweetAlert Peringatan Aktif');
        Swal.fire({
            title: 'Peringatan!',
            text: "{{ session('peringatan') }}",
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    @endif
    
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

document.getElementById('togglePassword').addEventListener('change', function () {
      // Toggle visibility for the 'password' field
      const passwordField = document.getElementById('password');
      const confirmPasswordField = document.getElementById('konfirmasi_password');
      
      if (this.checked) {
          passwordField.type = 'text';
          confirmPasswordField.type = 'text';
      } else {
          passwordField.type = 'password';
          confirmPasswordField.type = 'password';
      }
  });
</script>

@endsection
