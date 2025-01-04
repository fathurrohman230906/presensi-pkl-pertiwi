<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Mono - Responsive Admin & Dashboard Template</title>
  <!-- theme meta -->
  <meta name="theme-name" content="mono" />
  <!-- GOOGLE FONTS -->
<link href="{{ asset('assets/plugins/material/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/simplebar/simplebar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/nprogress/nprogress.css') }}" rel="stylesheet" />
{{-- <link href="{{ asset('assets/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" /> --}}
<link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="{{ asset('assets/plugins/toaster/toastr.min.css') }}" rel="stylesheet" />
<link id="main-css-href" rel="stylesheet" href="{{ asset('assets/css/style-siswa.css') }}" />
<link href="{{ asset('assets/images/favicon.png') }}" rel="shortcut icon" />
<link href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet" />

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">


<!-- Include jQuery and DataTables JS & CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
  .me {
    margin-right: 1rem;
  }

  a {
        text-decoration: none;
    }

    .breadcrumb {
        border: none;
    }

    .bg {
    background-color: rgba(0, 0, 0, 0.1); /* or any other color */
}

.img-user {
    width: 150px; 
    height: 150px; 
    object-fit: cover;
  }
</style>
<script src="{{ asset('assets/plugins/nprogress/nprogress.js') }}"></script>
</head>
  <body class="navbar-fixed sidebar-fixed" id="body">
    <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script>