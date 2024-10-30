    {{-- app head --}}
    @include('layouts.siswa.head')
    {{-- app head --}}

    <!-- App top Menu -->
    @include('layouts.siswa.sidemenu')
    <!-- * App top Menu -->

    <!-- App Capsule content web -->
    @yield('content')
    <!-- * App Capsule content web -->
    
    <!-- App Bottom Menu -->
    @include('layouts.siswa.bottom-menu')
    <!-- * App Bottom Menu -->

    {{-- app footer --}}
    @include('layouts.siswa.footer')
    {{-- app footer --}}