@extends('Superadmin.Layout.Master')

@section('css')
    <style>
       .image-container {
        position: relative;
        width: auto;
        float: left;
        }

        .image-checkbox {
            position: absolute;
            right: 0px;
            top: 0px;
        }
    </style>
@endsection


@section('content-header')
<div class="header py-1">
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row">
                <div class="col-lg-6 col-7 text-primary text-left">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home text-primary"></i> Website</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">@if(!$id) Add @else Edit @endif Advertise</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')


    <form action="{{ !$id ? url($url) : url($url.'/'.$id)}}" method="post"
        enctype="multipart/form-data"
    >
    @if($id)
        <input type="hidden" name="_method" value="PUT">
    @endif
    @csrf


        <div class="card card-body mt-3">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-control-label">Advertise Title :</label>
                    <input type="text" class="form-control form-control-sm"
                        id="advertise_title"
                        name="advertise_title"
                        value="{{ $advertise ? $advertise->advertise_title : NULL }}"
                        required>
                </div>
                <div class="col-md-6">
                    <label class="form-control-label">Where To Display :</label>
                    <select class="form-control select2"
                            id="pages"
                            name="pages[]"
                            multiple
                            required
                        >
                        <?php
                            $page = ["Index","Academic","Placement","Franchise","Service","Blog"];
                            foreach($page as $p){
                                $selected="";
                                if($advertise && in_array($p,$advertise_pages)){
                                    $selected="selected";
                                }
                                echo '<option value="'.$p.'" '.$selected.'>'.$p.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div> <!-- CARD-->

        <div class="card card-body mt--2">
            <div class="row">
                <div class="col">
                    <label class="form-control-label">Start Date :</label>
                    <input type="date" class="form-control form-control-sm"
                        id="start_date"
                        name="start_date"
                        value="{{ $advertise ? $advertise->start_date : date('Y-m-d') }}"
                        required>
                </div>

                <div class="col">
                    <label class="form-control-label">End Date :</label>
                    <input type="date" class="form-control form-control-sm"
                        id="end_date"
                        name="end_date"
                        value="{{ $advertise ? $advertise->end_date : date('Y-m-d',strtotime("+1 day")) }}"
                        required>
                </div>

                <div class="col">
                    <label class="form-control-label">Redirection Link :</label>
                    <input type="text" class="form-control form-control-sm"
                        id="ahref_url"
                        name="ahref_url"
                        value="{{ $advertise ? $advertise->ahref_url : NULL }}"
                        required>
                </div>
            </div>
        </div> <!-- CARD-->

        <div class="card card-body text-left mt--2">
            <div class="row">
                <div class="col-md-3">
                    <label class="form-control-label">Select Attachment :</label>
                    <label for="attachment_url" class="custom-file-upload mt-1 text-center bg-primary text-white"><b>Browse Image</b></label>
                    <input type="file"
                        id="attachment_url"
                        name="attachment_url[]"
                        onchange="preview_image();" multiple
                        >
                </div>
                <div class="col-md-9">
                    @if($advertise && count($advertise_attachments))
                    <div class="text-right p-0 m-0">
                        <button type="button" class="btn btn-danger btn-sm p-0" onclick="delete_images({{$id}})">Delete</button>
                    </div>
                    @endif
                    <div id="preview" style="border:1px solid black;height:150px">
                        @if($advertise && count($advertise_attachments))
                            @foreach($advertise_attachments as $attachment_id=>$attachment_url)
                                <div class="image-container" id="image-container-{{$attachment_id}}">
                                    <img src="{{asset($attachment_url)}}" style="height: 100px;width100px" id="attachment_url_{{$attachment_id}}">
                                    <input type="checkbox" class="image-checkbox"
                                            id="checkbox_{{$attachment_id}}}"
                                            value="{{$attachment_id}}"/>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body mt--3">
            <div class="row m-0">
                <div class="col-md-2">
                    <label class="form-control-label">Status :</label>
                </div>
                <div class="col-md-4 text-left d-flex justify-content-start">
                    <div class="">
                        <input type="radio"
                            id="is_active_1"
                            name="is_active"
                            value="1"
                            {{$advertise ? ($advertise->is_active==1 ? "checked" :"") : "checked" }}
                            >
                            Active
                    </div>
                    <div class="form-group ml-3">
                        <input type="radio"
                            id="is_active_0"
                            name="is_active"
                            value="0"
                            {{$advertise && $advertise->is_active==0 ? "checked" :"" }}
                            >
                            Deactive
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-md-2">
                    <label class="form-control-label">Remark :</label>
                </div>
                <div class="col-md-6 text-left">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm input_text alpha"
                            id="remark"
                            name="remark"
                            value="{{  $advertise ? $advertise->remark:"" }}"
                            >
                    </div>
                </div>
            </div>
        </div>        <!--CARD-->

        <div class="card p-0 mt--4 p-0">
            <div class="card-body p-2 text-center">
                    @if(!$id)
                        <button type="submit" name="button_type" value="SAVE" class="btn btn-primary btn-sm">Save</button>
                        <button type="submit" name="button_type" value="SAVE_AND_ADD_ANOTHER" class="btn btn-info btn-sm">Save And Add Another</button>
                    @else
                        <button type="submit" name="button_type" value="UPDATE" class="btn btn-primary btn-sm">Update</button>
                    @endif
                    <a href="{{ url($url) }}" class="btn btn-danger btn-sm">Cancel</a>
            </div>
        </div>
    </form>

@endsection

@push('scripts')
<script>
    function preview_image()
    {
        var total_file=document.getElementById("attachment_url").files.length;
        <?php if(!$id){ ?>
        $('#preview').html("");
        <?php } ?>

        for(var i=0;i<total_file;i++)
        {
            $('#preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"' style='height:100px;width:100px'>");
        }
    }

    function delete_images(advertise_id){
        var ids=[];
        $('.image-checkbox').each(function()
        {
            if($(this).is(':checked')){
                // alert($(this).val());
                ids.push($(this).val());
            }
        });

        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "{{ url($url.'/delete-images') }}",
                type:"post",
                data:{'advertise_id':advertise_id,'ids':ids},
                success: function(res){
                    alert(res.message);
                    if(res.status==1){
                        $.each(ids, function( i, l ){
                            $('#image-container-'+l).hide();
                        });
                    }
                }
            });
    }

</script>
@endpush

