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
  </head>
  <body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <form action="{{ route('Authentication.login') }}" method="post">
                    @csrf
                    
                    @if(session('logout'))
                        <div class="alert alert-success">
                            {{ session('logout') }}.
                        </div>
                    @endif

                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                      <div class="card-body p-5 text-center">
            
                        <h3 class="mb-5">Sign in</h3>
            
                        <div data-mdb-input-init class="form-outline mb-4">
                          <input type="email" id="typeEmailX-2" name="email" class="form-control form-control-lg" />
                          <label class="form-label" for="typeEmailX-2">Email</label>
                        </div>
      
                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" />
                                <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>
        
                            {{-- <div class="d-flex justify-content-end position-relative togglePassword" id="togglePassword">
                                <i class="fa-solid fa-eye"></i>
                            </div> --}}
            
                        <!-- Checkbox -->
                        <div class="d-flex justify-content-between">
                            <div class="form-check d-flex justify-content-start mb-4">
                              <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                              <label class="form-check-label" for="form1Example3"> Simpan sesi login </label>
                            </div>
                            <p class="small"><a class="text-dark-50" href="">Forgot password?</a></p>
                        </div>
      
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>
            
                        {{-- <hr class="my-4"> --}}
                        
                        {{-- <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary" style="background-color: #dd4b39;"
                          type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg btn-block btn-primary mb-2" style="background-color: #3b5998;"
                          type="submit"><i class="fab fa-facebook-f me-2"></i>Sign in with facebook</button> --}}
      
                        <div>
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
