<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>{{ $titlePage }}</title>
    <style>
        .flex-direction-column {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .ms-foto {
            margin-left: 5rem;
        }
        
        .ms-button-edit {
            margin-left: 11.5rem;
        }

        .image-size {
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            border-radius: 5px;
            overflow: hidden;
        }

    </style>
</head>
<body class="bg-secondary">
    <div class="pe-4 ps-4 pt-3">
        <div class="card shadow-sm">
            <div class="card-body d-flex align-items-center">
                <a href="/siswa-dashboard">
                    <i class="bi bi-arrow-left me-3 text-primary" style="font-size: 1.5rem;"></i>
                </a>
                <p class="mb-0 fw-bold">Kembali</p>
            </div>
        </div>
    </div>
    
    @foreach ($siswa as $DataSiswa)
    <div class="pe-4 ps-4 pt-4 pb-3">
        <div class="card bg-white">
            <div class="card-body">
                <h4 class="mb-0 text-dark">{{ $titlePage }}</h4>
                <div class="text-center">
                    <img id="editProfileImage" src="{{ $DataSiswa->foto ? asset('storage/FotoProfile/Siswa/' . $DataSiswa->foto) : 'https://via.placeholder.com/150' }}" class="{{ $DataSiswa->foto ? 'image-size' : 'rounded-circle' }} mb-3" alt="Foto Profil">
                    {{-- <img id="profileImage" src="https://via.placeholder.com/150" class="rounded-circle mb-3 mt-2" alt="Foto Profil"> --}}
                    <p>{{ $DataSiswa->nm_lengkap }}</p>
                    {{-- <p>{{ $DataSiswa->email }}</p> --}}
                </div>
            </div>
            <div class="card-footer flex-direction-column">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Detail Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link ms-3 me-3" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Edit Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Ganti Password</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="pe-4 ps-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Detail Profile</h5>
                        <div class="input-control mt-3">
                            <div class="mb-3 row">
                                <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="nis" type="text" value="{{ $DataSiswa->nis }}" aria-label="NIS" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="email" type="text" value="{{ $DataSiswa->email }}" aria-label="Email" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="fullName" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fullName" value="{{ $DataSiswa->nm_lengkap }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                <input type="text" class="form-control" 
                                    value="{{ $DataSiswa->jk == 'L' ? 'Laki-Laki' : ($DataSiswa->jk == 'P' ? 'Perempuan' : '-') }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="agama" value="{{ $DataSiswa->agama }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="kelas" value="{{ $DataSiswa->kelas->nm_kelas }}" readonly>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="description" class="col-sm-2 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="description" rows="3" readonly>{{ $DataSiswa->alamat }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <form action="{{ route('edit.profile.siswa') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="pe-4 ps-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Edit Profile</h5>
                            <div class="form-group text-center">
                                <img id="editProfileImage" src="{{ $DataSiswa->foto ? asset('storage/FotoProfile/Siswa/' . $DataSiswa->foto) : 'https://via.placeholder.com/150' }}" class="{{ $DataSiswa->foto ? 'image-size' : 'rounded-circle' }} mb-3" alt="Foto Profil">
                                <div class="form-group ms-foto d-flex align-items-center justify-content-center">
                                    <label for="profilePicture" class="me-1">Ganti Foto Profil</label>
                                    <input type="file" name="foto" class="form-control-file" id="profilePicture" accept="image/*" aria-label="Upload Profile Picture">
                                </div>
                            </div>
    
                            <div class="input-control mt-3">
                                <div class="mb-3 row">
                                    <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="nis" type="text" value="{{ $DataSiswa->nis }}" aria-label="NIS" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="email" name="email" type="text" value="{{ $DataSiswa->email }}" aria-label="Email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="fullName" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="nm_lengkap" class="form-control" id="fullName" value="{{ $DataSiswa->nm_lengkap }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" 
                                               value="{{ $DataSiswa->jk == 'L' ? 'Laki-Laki' : ($DataSiswa->jk == 'P' ? 'Perempuan' : '-') }}" 
                                               readonly>
                                        
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="agama" class="col-sm-2 col-form-label">Agama</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="agama" aria-label="Default select example">
                                            <option value="" disabled {{ $DataSiswa->agama ? '' : 'selected' }}>---- Pilih Agama Anda ----</option>
                                            <option value="Islam" {{ $DataSiswa->agama === "Islam" ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ $DataSiswa->agama === "Kristen" ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katholik" {{ $DataSiswa->agama === "Katholik" ? 'selected' : '' }}>Katholik</option>
                                            <option value="Buddha" {{ $DataSiswa->agama === "Buddha" ? 'selected' : '' }}>Buddha</option>
                                            <option value="Hindu" {{ $DataSiswa->agama === "Hindu" ? 'selected' : '' }}>Hindu</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="kelas" value="{{ $DataSiswa->kelas->nm_kelas }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="description" class="col-sm-2 col-form-label">Alamat</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="alamat" id="description" rows="3">{{ $DataSiswa->alamat }}</textarea>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning ms-button-edit"><i class="bi bi-pencil-square"></i> Edit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <form action="{{ route('edit.password.siswa') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="pe-4 ps-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Ganti Password</h5>
                            
                            <div class="input-control mt-3">
                                <div class="mb-3 row">
                                    <label for="fullName" class="d-none col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="hidden" name="email" class="form-control" id="fullName" value="{{ $DataSiswa->email }}" readonly>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="nis" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="nis" type="text" name="password" aria-label="NIS">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="email" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" id="email" name="KonfirmasiPassword" type="text" aria-label="Email">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning ms-button-edit"><i class="bi bi-pencil-square"></i> Ubah Password</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach


    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
    
    
    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
