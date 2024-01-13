
@extends('Website.Layout.app')
@section('content')
    <!-- Page Banner Section -->
        <section class="page-banner" style="height:10px !important;padding:160px 0px 100px !important;">
            <h1>About Us</h1>
        </section>
    <!--End Banner Section -->

    @endsection

    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcaOOcFcQ0hoTqANKZYz-0ii-J0aUoHjk"></script>
        <script src="{{url('website/js/map-script.js')}}"></script>
    @endpush
