@include('layouts.head')
    <div id="toaster"></div>
    <!-- ====================================
    ——— WRAPPER
    ===================================== -->
    <div class="wrapper">
        <!-- ====================================
          ——— LEFT SIDEBAR WITH OUT FOOTER
        ===================================== -->
        @include('layouts.sidebar')
      <!-- ====================================
      ——— PAGE WRAPPER
      ===================================== -->
      <div class="page-wrapper">
          <!-- Header -->
          @include('layouts.header')
        <!-- ====================================
        ——— CONTENT WRAPPER
        ===================================== -->
        <div class="content-wrapper">
          <div class="content">
            @yield('content')
          </div>
        </div>
          <!-- Footer -->
          @include('layouts.footer')
      </div>
    </div>
@include('layouts.footer-link')