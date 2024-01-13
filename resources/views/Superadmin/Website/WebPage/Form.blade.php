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
                                <a href="#"><i class="fas fa-home text-primary"></i> Website</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">@if(!$id) Add @else Edit @endif Page</a></li>
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
                <label class="form-control-label">Select Menu Service :</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <select class="form-control form-control-sm"
                        id="website_menu_service_id"
                        name="website_menu_service_id"
                    >
                    <?php
                        echo '<option value="">Select Menu</option>';
                        foreach($menu_services as $ms){
                            $selected="";
                            if($page && $page->website_menu_service_id==$ms->id){
                                $selected="selected";
                            }
                            echo '<option value="'.$ms->id.'" '.$selected.'>'.$ms->menu_service_name.'</option>';
                        } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Select Service:</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <select class="form-control form-control-sm"
                        id="master_service_id"
                        name="master_service_id"
                    >
                    <?php
                        echo '<option value="">Select Service</option>';
                        foreach($services as $s){
                            $selected="";
                            if($page && $page->master_service_id==$s->id){
                                $selected="selected";
                            }
                            echo '<option value="'.$s->id.'" '.$selected.'>'.$s->service_name.'</option>';
                        } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Redirection URL :</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm"
                        id="redirection_url"
                        name="redirection_url"
                        value="{{  $page ? $page->redirection_url: '#' }}"
                        required>
                </div>
            </div>
            <div class="col-md-3 text-left">
                <small class="form-control-label">'#' means no link </small>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Meta Keyword:</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm"
                        id="meta_keywords"
                        name="meta_keywords"
                        value="{{  $page ? $page->meta_keywords: NULL }}"
                        required>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Meta Description:</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <textarea type="text" class="form-control form-control-sm"
                        id="meta_description"
                        name="meta_description"
                        required>{{  $page ? $page->meta_description: NULL }}</textarea>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Main Content:</label>
            </div>
            <div class="col-md-9 text-left">
                <div class="form-group">
                    <textarea type="text" class="form-control form-control-sm"
                        id="main_content"
                        name="main_content"
                        required>{{  $page ? $page->main_content: NULL }}</textarea>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Status :</label>
            </div>
            <div class="col-md-3 text-left d-flex justify-content-start">
                <div class="">
                    <input type="radio"
                        id="is_active_1"
                        name="is_active"
                        value="1"
                        {{$page ? ($page->is_active==1 ? "checked" :"") : "checked" }}
                        >
                        Active
                </div>
                <div class="form-group ml-3">
                    <input type="radio"
                        id="is_active_0"
                        name="is_active"
                        value="0"
                        {{$page && $page->is_active==0 ? "checked" :"" }}
                        >
                        Deactive
                </div>
            </div>
        </div>
        <div class="row m-0">
            <div class="col-md-3 text-right">
                <label class="form-control-label">Remark :</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm input_text alpha"
                        id="remark"
                        name="remark"
                        value="{{  $page ? $page->remark:"" }}"
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
    CKEDITOR.replace('main_content');
</script>
@endpush


