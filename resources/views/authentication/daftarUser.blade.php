<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <!-- Font Awesome -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
    rel="stylesheet"
    />
    <!-- MDB -->
    <link
    href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.min.css"
    rel="stylesheet"
    />

    <style>
    </style>
  </head>
  <body>
    <section class="vh-50" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-8 col-xl-12">
                <form action="{{ route('Authentication.daftar') }}" method="post">
                    @csrf
                    
                    @if(session('logout'))
                        <div class="alert alert-success">
                            {{ session('logout') }}.
                        </div>
                    @endif

                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                      <div class="card-body p-5 text-center">
            
                        <h3 class="mb-5">Sign in</h3>

                        <div class="d-flex mb-3">
                            <div data-mdb-input-init class="form-outline me-1">
                                <input type="number" id="typenisX-2" name="nis" class="form-control form-control-lg" />
                                <label class="form-label" for="typenisX-2">Nis</label>
                            </div>
                            <div data-mdb-input-init class="form-outline ms-1">
                                <input type="email" id="typenisX-2" name="email" class="form-control form-control-lg" />
                                <label class="form-label" for="typenisX-2">Email</label>
                            </div>
                            
                        </div>
                        
                        <div class="d-flex mb-3">
                            <select class="form-select" name="jk" aria-label="Default select example">
                                <option selected>----- Pilih Jenis Kelamin -----</option>
                                <option value="L">Laki Laki</option>
                                <option value="P">Perempuan</option>
                            </select>

                            <div class="me-1 ms-1"></div>
                        
                            <select class="form-select" name="kelasID" aria-label="Default select example">
                                <option selected>----- Pilih Kelas -----</option>
                                @foreach ($kelas as $dataKelas)    
                                    <option value="{{ $dataKelas->kelasID }}">{{ $dataKelas->nm_kelas }}</option>
                                @endforeach
                            </select> 
                        </div>

                        <div class="d-flex mb-3">
                            <div data-mdb-input-init class="form-outline me-1">
                                <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" />
                                <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>
                            {{-- <div data-mdb-input-init class="form-outline ms-1">
                                <input type="text" id="typenisX-2" name="nm_lengkap" class="form-control form-control-lg" />
                                <label class="form-label" for="typenisX-2">Nama Lengkap</label>
                            </div> --}}
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Daftar</button>
            
                        <hr class="my-4">
                        
                        {{-- <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;"
                          type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
                          type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button> --}}
      
                        <div>
                          <p class="mb-0">Sudah Punya akun? <a href="/login" class="text-dark-50 fw-bold">klik di sini</a></p>
                        </div>
            
            
                      </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </section>
      <!-- MDB -->
<script
type="text/javascript"
src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.0.0/mdb.umd.min.js"
></script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('typePasswordX-2');

    togglePassword.addEventListener('click', function () {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.querySelector('i').classList.toggle('fa-eye');
        this.querySelector('i').classList.toggle('fa-eye-slash');
    });
</script>
  </body>
</html>
