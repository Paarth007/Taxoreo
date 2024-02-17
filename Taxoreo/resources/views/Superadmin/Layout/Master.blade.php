@extends('Layout.app')


@section('css')
@endsection
@section('portal')

@include('Superadmin.Layout.Sidebar')

<div class="main-content" id="panel">

    @include('Superadmin.Layout.Navbar')


    @yield('content-header')
    <div class="container">
        <div class="flash-message  pl-5 pr-5 mt-2" style="border-radius:0px">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <p class="alert alert-{{ $msg }} text-white p-1" style="color:#ffff;">
                        <b>{{ Session::get('alert-' . $msg) }} </b>
                        <a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
                    </p>
                    {{ session()->forget('alert-' . $msg) }}
                @endif
            @endforeach
        </div> <!-- end .flash-message -->

        @yield('content')
    </div>
</div>
@endsection

