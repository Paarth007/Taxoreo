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
                            <li class="breadcrumb-item"><a href="#">@if(!$id) Add @else Edit @endif Blog</a></li>
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

    <div class="row">
        <div class="col-md-9">

            <div class="card card-body">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-control-label">Blog Title :</label>
                        <input type="text" class="form-control form-control-sm"
                            id="blog_title"
                            name="blog_title"
                            value="{{ $blog ? $blog->blog_title : NULL }}"
                            required
                            oninput="generate_slug(this.value)">
                    </div>
                </div>
            </div> <!-- CARD-->

            <div class="card card-body mt--3">
                <div class="row">
                    <div class="col-md-12">
                        <label class="form-control-label">Blog Slug :</label>
                        <input type="text" class="form-control form-control-sm"
                            id="blog_slug"
                            name="blog_slug"
                            value="{{ $blog ? $blog->blog_slug : NULL }}"
                            required>
                    </div>
                </div>
            </div> <!-- CARD-->

            <div class="card card-body mt--3">
                <div class="row">
                    <div class="col-md-12 text-left">
                        <label class="form-control-label">Description :</label>
                        <textarea class="form-control form-control-sm"
                            id="description"
                            name="description"
                            required>
                            {{ $blog ? $blog->description : NULL }}
                        </textarea>
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
                                {{$blog ? ($blog->is_active==1 ? "checked" :"") : "checked" }}
                                >
                                Active
                        </div>
                        <div class="form-group ml-3">
                            <input type="radio"
                                id="is_active_0"
                                name="is_active"
                                value="0"
                                {{$blog && $blog->is_active==0 ? "checked" :"" }}
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
                                value="{{  $blog ? $blog->remark:"" }}"
                                >
                        </div>
                    </div>
                </div>
            </div>        <!--CARD-->


        </div> <!-- COL-MD-9 -->

        <div class="col-md-3">
            <div class="card card-body text-center p-2">
                <div class="p-0 m-0 border ml-4" style="height:230px;width:80%">
                    <img id="preview" style="height:100%;width:100%"
                       @if($blog && $blog->attachment_url)
                        src="{{ url($blog->attachment_url) }}"
                       @endif
                    >
                </div>
                <label for="attachment_url" class="custom-file-upload mt-1 text-center bg-primary text-white"><b>Browse Image</b></label>
                    <input type="file"  id="attachment_url" name="attachment_url" accept="image/*;capture=camera"
                        capture="camera"
                        onchange="document.getElementById('preview').src = window.URL.createObjectURL(this.files[0])"
                        >
                    <small class="text-success text-center" id="attachment_url-name"></small>
            </div>
        </div> <!-- COL-MD-3 -->

    </div><!-- ROW -->



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
    CKEDITOR.replace('description');
    function generate_slug(value){
       $('#blog_slug').val(value.replace(/ /g,"-"));
    }
</script>
@endpush

