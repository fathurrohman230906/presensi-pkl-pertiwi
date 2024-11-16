<style>
    .img-size {
        object-fit: cover;
        border-radius: 100%;
        height: 100px;
        width: 100px;
    }
    
    .padding {
        padding-top: 1rem;
    }
</style>
<div class="section" id="user-section">
    <div id="user-detail">
        <div class="avatar">
            @php
            $nis = session('nis');
            $Siswa = App\Models\Siswa::with('kelas', 'perusahaan')->where('nis', $nis)->get();
            @endphp
            @foreach ($Siswa as $DataSiswa)
                <img id="editProfileImage" src="{{ $DataSiswa->foto ? asset('storage/FotoProfile/Siswa/' . $DataSiswa->foto) : 'assets/img/sample/avatar/avatar1.jpg' }}" class="{{ $DataSiswa->foto ? 'img-size' : 'imaged w64 rounded' }}" alt="Foto Profil">
            @endforeach
            {{-- <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w64 rounded"> --}}
        </div>
        <div id="user-info">
            @php
            $role = session('role');
            $models = ucfirst($role);
            $userClass = "App\\Models\\$models"; // Buat nama kelas penuh
            $userIdField = match ($role) {
                'siswa' => 'nis',
                'admin' => 'adminID',
                'pembimbing' => 'pembimbingID',
                'wali_kelas' => 'wali_kelasID',
            };
            
            $user = $userClass::where($userIdField, session($userIdField))->get();
            
            $nm_lengkap = $user->pluck('nm_lengkap')->first(); // Ambil nama lengkap pertama
            @endphp
            @foreach ($Siswa as $DataSiswa)
                <h2 id="user-name" class="{{ $DataSiswa->foto ? "padding" : "" }}">{{ $nm_lengkap }}</h2>
            @endforeach

            <span id="user-role">{{ ucfirst($role) }}</span>
            <div class="logout-button">
                <form action="/logout" method="post">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}">
                    <button type="submit" class="btn btn-danger">keluar</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- <div class="section" id="menu-section">
      <div class="card">
          <div class="card-body text-center">
              <div class="list-menu">
                  <div class="item-menu text-center">
                      <div class="menu-icon">
                          <a href="" class="green" style="font-size: 40px;">
                              <ion-icon name="person-sharp"></ion-icon>
                          </a>
                      </div>
                      <div class="menu-name">
                          <span class="text-center">Profil</span>
                      </div>
                  </div>
                  <div class="item-menu text-center">
                      <div class="menu-icon">
                          <a href="" class="danger" style="font-size: 40px;">
                              <ion-icon name="calendar-number"></ion-icon>
                          </a>
                      </div>
                      <div class="menu-name">
                          <span class="text-center">Cuti</span>
                      </div>
                  </div>
                  <div class="item-menu text-center">
                      <div class="menu-icon">
                          <a href="" class="warning" style="font-size: 40px;">
                              <ion-icon name="document-text"></ion-icon>
                          </a>
                      </div>
                      <div class="menu-name">
                          <span class="text-center">Histori</span>
                      </div>
                  </div>
                  <div class="item-menu text-center">
                      <div class="menu-icon">
                          <a href="" class="orange" style="font-size: 40px;">
                              <ion-icon name="location"></ion-icon>
                          </a>
                      </div>
                      <div class="menu-name">
                          Lokasi
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div> --}}