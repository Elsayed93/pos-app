<!DOCTYPE html>
<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

{{-- head --}}
@include('layouts.dashboard.head')
{{-- end of head --}}

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        {{-- header --}}
        @include('layouts.dashboard.header')
        {{-- end of header --}}

        {{-- sidebar --}}
        @include('layouts.dashboard._aside')
        {{-- end of sidebar --}}

        @yield('content')

        @include('partials._session')

        {{-- footer --}}
        @include('layouts.dashboard.footer')
        {{-- end of footer --}}

    </div><!-- end of wrapper -->

    {{-- js --}}
    @include('layouts.dashboard.js')
    {{-- end of js --}}
</body>

</html>
