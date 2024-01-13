<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Client</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="icon" href="{{ url('backend_template/assets/img/brand/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('backend_template/assets/css/argon.css?v=1.1.0') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ url('backend_template/assets/vendor/select2/dist/css/select2.min.css') }}">
    <script src="{{ url('backend_template/assets/js/shortcuts.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js "></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js "></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js "></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="{{ url('backend_template/assets/js/ckeditor/ckeditor.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/> --}}

    <style>
        .form-control-label{
            font-size:13px !important;
            margin:0px !important;
        }

        /* Select2 multiple */
        .select2 .select2-container .select2-container--classic .select2-selection .select2-selection--single{
            background-color: white !important;
            border: 1px solid #DEE2E6 !important;
            border-radius: 4px;
            cursor: text;
            outline: 0;
        }
       .select2-container--classic .select2-selection--multiple{
            background-color: white;
            border: 1px solid #DEE2E6;
            border-radius: 4px;
            cursor: text;
            outline: 0;
        }
        /* Selected Option */
        .select2-container--classic .select2-selection--multiple .select2-selection__choice{
            background-color:#5E72E4;
            color:white;
            border-radius: 4px;
            font-size:12px;
            cursor: default;
            float: left;
            margin-right: 2px;
        }
        /* Remove Selected Option */
        .select2-selection__choice__remove{
            background:transparent;
            color:white !important;
            border-radius: 4px;
            border: none;
        }

        .custom_breadcrumb{
            .font-size:10px
        }

        /* .custom_upload{
            border: none;
            background: #084cdf;
             border-radius: 10px;
            color: #fff;
            cursor: pointer;
            transition: background .2s ease-in-out;
            width: 100px;
        } */

        .custom_upload {
            opacity: 0;
            width: 0.1px;
            height: 0.1px;
        }
        /* .file-input{
            display: block;
            margin-left: auto;
            margin-right: auto;
        } */
        .file-input label {
            display: block;
            font-size:12px;
            width: 80px;
            height: 25px;
            border-radius: 25px;
            background: #5E72E4;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: transform .2s ease-out;
            }

    </style>
@yield('css')

</head>
<body>

@include('Client.Layout.Sidebar')

<div class="main-content" id="panel">

    @include('Client.Layout.Navbar')
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

<script>
</script>
@stack('scripts')
<script src="{{ url('backend_template/assets/js/graph/canvasjs.min.js') }}"></script>
<script src="{{ url('backend_template/assets/js/graph/jquery.canvasjs.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/js-cookie/js.cookie.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/select2/dist/js/select2.min.js') }}"></script>

<!-- Optional JS -->
<script src="{{ url('backend_template/assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ url('backend_template/assets/vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<!-- <script src="{{ url('backend_template/assets/vendor/datatables.net-select/js/dataTables.select.min.js') }}"></script> -->

<script src="{{ url('backend_template/assets/js/argon.js?v=1.1.0') }}"></script>

</body>
</html>



