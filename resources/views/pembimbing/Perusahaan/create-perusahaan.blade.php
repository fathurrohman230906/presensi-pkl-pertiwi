@extends('layouts.main')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<h3 class="fw-bold mb-3">Create Perusahaan</h3>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pembimbing.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Perusahaan</li>
    </ol>
</nav>

<div class="card card-default">
    <div class="card-header">
      <h2>Create Perusahaan</h2>
      <a href="{{ route('pembimbing.perusahaan') }}" class="btn btn-danger">Kembali</a>
    </div>
    <div class="card-body">
      <!-- Create Perusahaan -->
      <form action="{{ route('pembimbing.perusahaan.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="" class="form-label">Pendiri Perusahaan</label>
                <input type="text" class="form-control" id="" name="pendiri">
            </div>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label">Nama Perusahaan</label>
                <input type="text" class="form-control" id="" name="nm_perusahaan">
            </div>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label">Email Perusahaan</label>
                <input type="text" class="form-control" id="" name="email">
            </div>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label">Nomer Telepon Perusahaan</label>
                <input type="number" class="form-control" id="" name="no_tlp">
            </div>
            <div class="col-md-6 mb-3">
                <label for="" class="form-label">Tentang Perusahaan</label>
                <textarea class="form-control" name="deskripsi" id="alamat" rows="2"></textarea>
                {{-- <input type="number" class="form-control" id="" name="deskripsi"> --}}
                <small class="text-danger">Tidak wajib di isi</small>
              </div>
              <div class="col-md-6 mb-3">
                <label for="" class="form-label">Alamat Perusahaan</label>
                <textarea class="form-control" name="alamat" id="alamat" rows="3"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3">
            <i class="fas fa-plus"></i> Tambah
        </button>
      </form>
    </div>
  </div>
@endsection
