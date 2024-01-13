@extends('Superadmin.Layout.Master')

@section('content-header')

<div class="header py-1">
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row">
                <div class="col-lg-6 col-7 text-primary text-left">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home text-primary"></i> Master</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">@if(!$id) Add @else Edit @endif Document</a></li>
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

    <div class="card card-body">
        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Document Type :
                </label>
            </div>
            <div class="col-md-9 text-left d-flex justify-content-start" style="font-size:14px;">
                <div class="form-group ml-3">
                    <input type="radio"
                        id="type_upload"
                        name="document_type"
                        value="UPLOAD"
                        {{$document ? ($document->document_type=="UPLOAD" ? "checked" :"") : "checked" }}
                        onchange="change_view(this.value)"
                        >
                        Upload Only
                </div>
                <div class="form-group ml-3">
                    <input type="radio"
                        id="type_download"
                        name="document_type"
                        value="DOWNLOAD"
                        {{ $document && $document->document_type=="DOWNLOAD" ? "checked" :""  }}
                        onchange="change_view(this.value)"
                        >
                        Download Only
                </div>
                <div class="form-group ml-3">
                    <input type="radio"
                        id="type_download_upload"
                        name="document_type"
                        value="DOWNLOAD_UPLOAD"
                        {{$document && $document->document_type=="DOWNLOAD_UPLOAD" ? "checked" :""  }}
                        onchange="change_view(this.value)"
                        >
                        Download and Upload
                </div>
            </div>
        </div>
        <?php
            if($document && $document->document_type!="UPLOAD"){
                $style="";
            }else{
                $style="display:none";
            }
        ?>
        <div class="row m-0 upload_document_class" style="{{$style}}">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Upload Document :
                </label>
            </div>

            @if($document && $document->download_link && ($document->document_type=="DOWNLOAD" || $document->document_type=="DOWNLOAD_UPLOAD"))
                <div class="col-md-4 text-left">
            @else
                <div class="col-md-6 text-left">
            @endif
                <div class="form-group">
                        <input type="file" id="document" name="document">
                        <label for="document"
                               class="custom-file-upload text-center bg-primary text-white"
                               id="custom_upload_button"
                               >
                            <b><i class="fa fa-paperclip" aria-hidden="true"></i> Upload</b>
                        </label>
                </div>
            </div>
            @if($document && $document->download_link)
                <div class="col-md-2 text-left">
                        <a href="{{$document->download_link}}"
                            class="btn btn-outline-warning btn-sm"
                            target="_blank">Download</a>
                </div>
            @endif
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Document Name :
                </label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm "
                        id="document_name"
                        name="document_name"
                        value="{{$document ? $document->document_name:"" }}"
                        required>
                </div>
            </div>
        </div>


        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Accepted Format :
                </label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <select type="text" class="form-control form-control-sm select2" multiple="true"
                        id="accepted_format"
                        name="accepted_format[]"
                    >
                    <?php
                        $accepted_format=['xls','pdf','png','jpg','jpeg'];
                        $selected_format=[];
                        if($document && $document->accepted_format){
                            $selected_format=explode(',',$document->accepted_format);
                        }
                        foreach($accepted_format as $a){
                            $selected="";
                            if(count($selected_format) && in_array($a,$selected_format)){
                                $selected="selected";
                            }
                            echo '<option value="'.$a.'" '.$selected.'>'.$a.'</option>';
                        }
                    ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Min. Size :
                </label>
            </div>
            <div class="col-md-2 text-left">
                <div class="form-group">
                    <input type="number" class="form-control form-control-sm "
                        id="min_size"
                        name="min_size"
                        value="{{$document ? $document->min_size: "0" }}"
                        required>
                </div>
            </div>
            <div class="col-md-4 text-left">
                <div class="form-group">
                    <select type="text" class="form-control form-control-sm"
                    id="min_size_type"
                    name="min_size_type"
                    >
                        <option value="KB">KB</option>
                        <option value="MB">MB</option>
                        <option value="GB">GB</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Max. Size :
                </label>
            </div>
            <div class="col-md-2 text-left">
                <div class="form-group">
                    <input type="number" class="form-control form-control-sm "
                        id="max_size"
                        name="max_size"
                        value="{{$document ? $document->max_size: "0" }}"
                        required>
                </div>
            </div>
            <div class="col-md-4 text-left">
                <div class="form-group">
                    <select type="text" class="form-control form-control-sm"
                    id="max_size_type"
                    name="max_size_type"
                    >
                        <option value="KB">KB</option>
                        <option value="MB">MB</option>
                        <option value="GB">GB</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Status :
                </label>
            </div>
            <div class="col-md-3 text-left d-flex justify-content-start" style="font-size:14px;">
                <div class="">
                    <input type="radio"
                        id="is_active_1"
                        name="is_active"
                        value="1"
                        {{$document ? ($document->is_active==1 ? "checked" :"") : "checked" }}
                        >
                        Active
                </div>
                <div class="form-group ml-3">
                    <input type="radio"
                        id="is_active_0"
                        name="is_active"
                        value="0"
                        {{$document && $document->is_active==0 ? "checked" :"" }}
                        >
                        Deactive
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">
                    Remark :
                </label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm input_text alpha"
                        id="remark"
                        name="remark"
                        value="{{$document ? $document->remark:"" }}"
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
    function change_view(type)
    {
        if(type=="DOWNLOAD" || type=="DOWNLOAD_UPLOAD"){
            $('.upload_document_class').show();
        }else{
            $('.upload_document_class').hide();
        }
    }
</script>
@endpush

