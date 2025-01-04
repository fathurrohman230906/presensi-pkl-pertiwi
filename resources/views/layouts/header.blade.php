        @php
            $role = session('role');
            if($role === "admin") {
                $adminID = session('adminID');
                $directoryfoto = 'Admin';
                $data = App\Models\Admin::where('adminID', $adminID)->first();
              } elseif ($role === "pembimbing") {
              $pembimbingID = session('pembimbingID');
              $directoryfoto = 'Pembimbing';
              $data = App\Models\Pembimbing::with('jurusan')->where('pembimbingID', $pembimbingID)->first();
            } elseif ($role === "wali_kelas") {
              $directoryfoto = 'WaliKelas';
              $waliKelasID = session('wali_kelasID');
              $data = App\Models\WaliKelas::with('kelas')->where('wali_kelasID', $waliKelasID)->first();
            }
        @endphp
        <style>
          .navbar .navbar-right .navbar-nav .user-menu .Multiuser-image {
            object-fit: cover;
            width: 50px;
            height: 50px;
            border-radius: 0.25rem;
          }
        </style>
         <header class="main-header" id="header">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
              <!-- Sidebar toggle button -->
              <button id="sidebar-toggler" class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <div class="navbar-right ">
                <ul class="nav navbar-nav">
                  <!-- User Account -->
                  <li class="dropdown user-menu">
                    <button class="dropdown-toggle nav-link" data-toggle="dropdown">
                      <img src="{{ $data->foto ? asset('storage/FotoProfile/' . $directoryfoto . '/' . $data->foto) : asset('assets/images/user/u-xl-11.jpg') }}" class="{{ $data->foto ? 'Multiuser-image' : 'user-image' }} rounded-circle" alt="User Image" />
                      <span class="d-none d-lg-inline-block">{{ $data->nm_lengkap }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li>
                        <a class="dropdown-link-item" href="{{ route('profile.user') }}">
                          <i class="mdi mdi-account-outline"></i>
                          <span class="nav-text">My Profile</span>
                        </a>
                      </li>
                      {{-- <li>
                        <a class="dropdown-link-item" href="user-account-settings.html">
                          <i class="mdi mdi-settings"></i>
                          <span class="nav-text">Account Setting</span>
                        </a>
                      </li> --}}

                      <li class="dropdown-footer">
                        <form action="/logout" method="post" id="formLogout">
                          @csrf
                          <input type="hidden" name="role" value="{{ session('role') }}">
                          <a class="dropdown-link-item" href="#" onclick="buttonLogout(event)">
                            <i class="mdi mdi-logout"></i>
                            <span class="nav-text">Logout</span>
                          </a>
                        </form>
                      
                        <script>
                          function buttonLogout(event) {
                            event.preventDefault(); // Prevent default anchor behavior
                            const formLogout = document.getElementById('formLogout'); // Find the formLogout
                            formLogout.submit(); // Submit the formLogout
                          }
                        </script>
                      </li>
                      
                      {{-- <li class="dropdown-footer d-flex">
                        <form action="/logout" method="post">
                          @csrf
                          <input type="hidden" name="role" value="{{ session('role') }}">
                          <button type="submit" class="dropdown-link-item"><i class="mdi mdi-logout"></i>Log Out</button>
                        </form>
                      </li> --}}
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>