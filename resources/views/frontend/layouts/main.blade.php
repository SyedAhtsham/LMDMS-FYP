@if(Session::get('position') == "Driver")
    @include('frontend.layouts.driverHeader')
    @else
@include('frontend.layouts.header')

@endif

@yield('main-container')
@include('frontend.layouts.footer')

@yield('scripts')
