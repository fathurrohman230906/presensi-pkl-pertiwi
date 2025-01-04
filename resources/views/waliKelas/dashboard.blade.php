@extends('layouts.main')

@section('content')
<!-- Preconnect to external fonts for performance -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

<style>
.poppins-black {
  font-family: "Poppins", sans-serif;
  font-weight: 900;
  font-style: normal;
}

  .dashboard-card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Soft shadow for card */
  }

  .card-body {
    padding: 1.5rem;
  }
</style>

<h3 class="fw-bold mb-4">Dashboard</h3>

<section class="container">
  <div class="row">
    <div class="col-12 col-md-12 col-lg-6">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <i class="bi bi-people-fill fs-3 me-3"></i> <!-- Spacing for icon -->
            <div class="d-flex flex-column">
              <h5 class="fw-bold mb-1">Siswa</h5>
              <span class="fw-bold fs-4 poppins-black ms-2 
              {{ $siswaCount == 0 ? 'text-danger' : '' }}">
              {{ $siswaCount ?? 0 }}
            </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-12 col-lg-6">
      <div class="card dashboard-card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <i class="bi bi-building-fill fs-3 me-3"></i> <!-- Spacing for icon -->
            <div class="d-flex flex-column">
              <h5 class="fw-bold mb-1">Perusahaan</h5>
              <span class="fw-bold fs-4 poppins-black ms-2 
                {{ $perusahaanCount == 0 ? 'text-danger' : '' }}">
                {{ $perusahaanCount ?? 0 }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
          @if (session('peringatan'))
            Swal.fire({
                title: 'Peringatan!',
                text: "{{ session('peringatan') }}",
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        @endif
</script>
@endsection
