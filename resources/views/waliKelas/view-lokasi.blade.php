@extends('layouts.main')

@section('content')
    <!-- Link ke CSS Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* Atur ukuran peta */
        #map {
            height: 100vh;
        }
    </style>

    <h3 class="fw-bold mb-3">Lokasi Siswa {{ $siswa->nm_lengkap }}</h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/wali-kelas-dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lokasi Siswa</li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <a href="/kelola-presensi" class="btn btn-danger mb-3">Kembali</a>
            <div id="map"></div>
        </div>
    </div>

    <!-- Link ke JS Leaflet -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <!-- JS untuk peta -->
    <script>
        // Membuat peta dengan koordinat default yang di-passing dari controller
        var map = L.map("map").setView([{{ $latitude }}, {{ $longitude }}], 13);

        // Menambahkan tile layer (peta dasar) dari OpenStreetMap
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        // Menambahkan marker di posisi yang diterima dari controller
        L.marker([{{ $latitude }}, {{ $longitude }}])
            .addTo(map)
            .bindPopup("Lokasi Siswa: {{ $siswa->nm_lengkap }}")
            .openPopup();
        
        // Tidak perlu menggunakan map.locate() jika hanya menampilkan lokasi yang sudah ada
    </script>
@endsection
