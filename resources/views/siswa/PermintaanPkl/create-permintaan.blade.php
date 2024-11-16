<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap Demo with DataTables</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
      body {
        background-color: #37517e !important;
      }
      .text-bg-white {
        background-color: white!important;
      }

      .font-size {
        font-size: 15px;
      }

      #loader {
        position: fixed;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 99999;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      #loader .loading-icon {
        width: 42px;
        height: auto;
        animation: loadingAnimation 1s infinite;
      }

      @keyframes loadingAnimation {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      /* Initial state of loader, visible */
      #loader {
        display: flex;
      }

      /* Ensure button and form elements have proper spacing */
      .card-body {
        padding: 20px; /* Add some space inside the card */
      }

      .form-label {
        font-weight: bold;
      }

      .mb-3 {
        margin-bottom: 1rem;
      }

      .btn-pengajuan {
        margin-top: 20px; /* Space between form and button */
        width: 100%; /* Make button full-width */
      }
    </style>
  </head>
  <body>
    <div id="loader">
      <div class="spinner-border text-primary" role="status"></div>
    </div>

    <div class="container mt-5">
      <div class="d-flex justify-content-end mb-3">
        <a href="/permintaan-pkl" class="btn btn-danger p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
          Kembali
        </a>
      </div>

      <div class="card mb-3">
        <div class="card-body">
            <div class="p-2">
                <h3 class="fw-bold fs-2 text-dark">Buat Pengajuan Magang</h3>
                <p>Lengkapi data dan isi dengan data yang valid.</p>
            </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
            <div class="p-2">
                <h4 class="fw-bold text-dark mb-3">Form pengajuan</h4>
                <form action="{{ route('proses.create.permintaan.pkl') }}" method="post">
                    @csrf
                    <div class="row">
                      <div class="col-md-12 col-lg-6">
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">NIS</label>
                          <input type="number" class="form-control @error('nis') is-invalid @enderror" id="exampleInputEmail1" name="nis" value="{{ old('nis', session('nis')) }}" readonly>
                          @error('nis')
                            <div class="invalid-feedback">{{ $message }}</div>
                          @enderror                  
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-6">
                        <label for="exampleInputEmail1" class="form-label">Dunia Industri / Dinas</label>
                          <select class="form-select @error('perusahaanID') is-invalid @enderror" name="perusahaanID" aria-label="Default select example">
                            <option selected disabled>-- Silahkan Pilih --</option>
                            @foreach ($dataPerusahaan as $DataPerusahaan)
                              <option value="{{ $DataPerusahaan->perusahaanID }}">{{ $DataPerusahaan->nm_perusahaan }}</option>
                            @endforeach
                            </select>
                            @error('perusahaanID')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                  
                  <div class="row">
                      <div class="col-md-12 col-lg-6">
                          <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Mulai Tanggal</label>
                              <input type="date" class="form-control @error('bulan_masuk') is-invalid @enderror" name="bulan_masuk" id="exampleInputEmail1" aria-describedby="emailHelp">
                              @error('bulan_masuk')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      <div class="col-md-12 col-lg-6">
                          <div class="mb-3">
                              <label for="exampleInputEmail1" class="form-label">Sampai Tanggal</label>
                              <input type="date" class="form-control @error('bulan_keluar') is-invalid @enderror" id="exampleInputEmail1" name="bulan_keluar" aria-describedby="emailHelp">
                              @error('bulan_keluar')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                        </div>
                    </div>

                    <!-- Button at the bottom with margin-top -->
                    <button type="submit" class="btn btn-primary btn-pengajuan p-2 ps-3 pe-3 text-uppercase fw-bold font-size shadow-lg" style="color: white; text-shadow: 1px 1px 15px rgba(255, 255, 255, 0.8);">
                        Buat Pengajuan PKL
                      </button>
                </form>
              </div>
            </div>
        </div>
      </div>
    </div>

    <!-- jQuery (necessary for DataTables plugin) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
      $(document).ready(function() {
        // Simulate a loading delay of 1 second and hide the loader
        setTimeout(function() {
          $('#loader').fadeOut();
        }, 1000);  // 1000ms = 1 second
      });
    </script>
  </body>
</html>