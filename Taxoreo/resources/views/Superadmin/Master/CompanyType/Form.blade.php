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
                            <li class="breadcrumb-item"><a href="#">@if(!$id) Add @else Edit @endif Company Type</a></li>
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
                <label class="form-control-label">Company Type Name :</label>
            </div>
            <div class="col-md-6 text-left">
                <div class="form-group">
                    <input type="text" class="form-control form-control-sm"
                        id="company_type_name"
                        name="company_type_name"
                        value="{{ $company_type ? $company_type->company_type_name: NULL }}"
                        required>
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
                        {{$company_type ? ($company_type->is_active==1 ? "checked" :"") : "checked" }}
                        >
                        Active
                </div>
                <div class="form-group ml-3">
                    <input type="radio"
                        id="is_active_0"
                        name="is_active"
                        value="0"
                        {{$company_type && $company_type->is_active==0 ? "checked" :"" }}
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
                        value="{{  $company_type ? $company_type->remark:"" }}"
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
    function select_all(class_id,selection){
        $('.document_class_'+class_id).each(function(){
                this.checked =selection;
        });
    }
</script>
@endpush


