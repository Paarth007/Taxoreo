<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>TAXOREO</title>

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
         input[type="file"] {
            display: none;
        }

        .custom-file-upload {
            border: 1px solid #dee2e6;
            display: inline-block;
            width: 100%;
            padding: 5px;
            cursor: pointer;
            font-size: 13px;
            border-radius: 4px;
            margin-bottom: 0px;
        }

        .profile_pic {
            height: 40px;
            width: 40px;
            border-radius: 50px;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */

        }

        .zoom:hover {
            position: absolute;
            transform: scale(2.5);
            /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
            z-index: 10;
        }

        td.details-control {
            background: url("{{ url('backend_template/images/tr_add.png') }}") no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url("{{ url('backend_template/images/tr_remove.png') }}") no-repeat center center;
        }

        .fa-dot-circle{
            color:#5E72E4;
            font-size:12px !important;
            margin:0px !important;
            padding:0px !important;
        }

        /* input[type=file] {
            width: 350px;
            max-width: 100%;
            color: #444;
            padding: 5px;
            background: #fff;
            border-radius: 10px;
            border: 1px solid #555;
        } */
    </style>
    @yield('css')

</head>
<body>



        @yield('portal')



{{--
        @include('Messages.Email.Index');
        @include('Messages.SMS.Index');
        @include('Messages.WHATS_APP.Index');
 --}}

<script>

CKEDITOR.replace("email_message");
function getMessageModal(template_type) {

    $("#mobile_no_list").val();
    $("#mobile_no_template_id").val();
    $("#mobile_no_message").val();

    $("#email_list").val();
    $("#email_template_id").val();
    CKEDITOR.instances['email_message'].setData("");

    $("#whats_app_list").val();
    $("#whats_app_template_id").val();
    $("#whats_app_message").val();

    $("#email_message_modal").modal('hide');
    $("#sms_message_modal").modal('hide');
    $("#whats_app_message_modal").modal('hide');

    var user_ids = [];
    $('.select_all_individual_checkbox:checked').each(function() {
        user_ids.push($(this).val());
    });
    if(user_ids.length > 0)
    {
        $.ajax({
                method: "POST",
                url: "{{ url('message/get-message-modal') }}",
                data: {
                    'id': user_ids,
                    'template_type':template_type
                },
                success: function(res)
                {
                    if(res.status==0){
                        alert(res.message);
                    }
                    if(res.status==1)
                    {
                        if(template_type=="EMAIL"){
                            $("#email_list").val(res.data);
                            $("#email_message_modal").modal('show');
                        }

                        if(template_type=="SMS"){
                            $("#mobile_no_list").val(res.data);
                            $("#sms_message_modal").modal('show');
                        }

                        if(template_type=="WHATS_APP"){
                            console.log(res.data);
                            $("#whats_app_list").val(res.data);
                            $("#whats_app_message_modal").modal('show');
                        }

                    }
                }
        });
    }else{
        alert_message("success","<b>Select user before processing !!!</b>",350);
    }
}

function get_template_description(type,map_to,id){
    $.ajax({
            method: "POST",
            url: "{{ url('message/get-template-description') }}",
            data: {
                'id': id,
                'type': type,
            },
            success: function(res){
                if(res.status==0){
                    alert(res.message);
                }
                if(res.status==1){
                    if(type=="EMAIL"){
                        CKEDITOR.instances[map_to].setData(res.data);
                    }else{
                        $("#"+map_to).val(res.data);
                    }
                }
            }
        });
}


    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.select_all_individual_checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.select_all_individual_checkbox').each(function(){
                    this.checked = false;
                });
            }
        });
    });


    function get_course_dropdown(course_group_id,map_to)
    {
        var json_data = {'course_group_id': course_group_id,'type':"COURSE" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data){
                $("#"+map_to).html(data);
            }
        });
    }

    function get_subject_dropdown(course_id,map_to)
    {
        var json_data = {'course_id': course_id,'type':"SUBJECT" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    function get_batch_dropdown(subject_id,map_to)
    {
        var json_data = {'course_id': subject_id,'type':"BATCH" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    function get_course_batch_dropdown(subject_id,map_to)
    {
        var json_data = {'course_id': subject_id,'type':"COURSEWISE_BATCH" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    function get_topic_dropdown(subject_id,map_to)
    {
        var json_data = {'subject_id': subject_id,'type':"TOPIC" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    function get_city_dropdown(state_id,map_to)
    {
        var json_data = {'state_id': state_id,'type':"CITY" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    function copy_city_dropdown(state_id,map_to,city_id="")
    {
        var json_data = {'state_id': state_id,'type':"CITY" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
                if(city_id){
                    $("#"+map_to).val(city_id);
                }
            }
        });
    }

    function get_payment_template(course_id,map_to)
    {
        var json_data = {'course_id': course_id,'type':"PAYMENT_TEMPLATE" };
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: "{{ url('Supportive/get_dropdown') }}",
            data: json_data,
            success: function (data)
            {
                $("#"+map_to).html(data);
            }
        });
    }

    $(".select2").select2({
            theme: "classic"
    });

    function alert_message(icon,text,width){
        Swal.fire({
                    html:text,
                    icon: icon,
                    width: width,
                });
    }

    function  refresh_search_result(){
        $('#data-table').DataTable().ajax.reload();
    }
    function  refresh_datatable(){
        $('#data-table').DataTable().ajax.reload();
    }

    $(document).on('keypress', '.email', function(event){
        var regex = new RegExp("^[A-Za-z0-9_@. ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
        event.preventDefault();
        return false;
        }
    });

    $(document).on('keypress', '.mobile_no', function(event){
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '.marks_obtained', function(event){
        var regex = new RegExp("^[0-9/]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '.numeric', function(event){
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('keypress', '.alpha', function(event){
        var regex = new RegExp("^[A-Za-z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
        event.preventDefault();
        return false;
        }
    });

    $(document).on('keypress', '.alphaSpecial', function(event){
        var regex = new RegExp("^[A-Za-z&._ ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
        event.preventDefault();
        return false;
        }
    });


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

