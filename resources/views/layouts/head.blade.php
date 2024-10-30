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
<link href="{{ asset('assets/plugins/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<link href="{{ asset('assets/plugins/toaster/toastr.min.css') }}" rel="stylesheet" />
<link id="main-css-href" rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
<link href="{{ asset('assets/images/favicon.png') }}" rel="shortcut icon" />

<style>
  .me {
    margin-right: 1rem;
  }
</style>
<script src="{{ asset('assets/plugins/nprogress/nprogress.js') }}"></script>
</head>
  <body class="navbar-fixed sidebar-fixed" id="body">
    <script>
      NProgress.configure({ showSpinner: false });
      NProgress.start();
    </script>