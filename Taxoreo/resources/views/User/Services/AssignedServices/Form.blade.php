@extends('User.Layout.Master')

@section('content-header')
<div class="header py-1">
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row">
                <div class="col-lg-6 col-7 text-primary text-left">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home text-primary"></i> User Service</a>
                            </li>
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
    <div class="row">
        <div class="col-md-6">
            <form action="{{ !$id ? url($url) : url($url.'/'.$id)}}" method="post"
            enctype="multipart/form-data"
        >
        @if($id)
            <input type="hidden" name="_method" value="PUT">
        @endif
        @csrf
        <div class="card card-body">
            <div class="row m-0">
                <div class="col-md-4 text-right">
                    <label class="form-control-label">
                        Service Name :
                    </label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm"
                            id=""
                            name=""
                            value="{{$user_service->service_name}}"
                            readonly
                            >
                    </div>
                </div>
            </div>
            <div class="row m-0">
                <div class="col-md-4 text-right">
                    <label class="form-control-label">
                        Current Status :
                    </label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <input type="hidden" name="old_status" value="{{$user_service->current_status}}">

                        <select type="text" class="form-control form-control-sm"
                                id="current_status"
                                name="current_status"
                                value="{{$user_service->current_status}}"
                            >
                            <option value="">No status selected</option>
                            <?php
                                $service_status=["IN_PROGRESS","HOLD","COMPLETE"];
                                foreach($service_status as $ss){
                                        $selected="";
                                        if($selected=="" && $user_service->current_status && $user_service->current_status==$ss){
                                            $selected="selected";
                                        }
                                    echo '<option value="'.$ss.'" '.$selected.'>'.$ss.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-0 p-0 text-right">
                @if(!$id)
                    <button type="submit" name="button_type" value="SAVE" class="btn btn-primary btn-sm">Save</button>
                    <button type="submit" name="button_type" value="SAVE_AND_ADD_ANOTHER" class="btn btn-info btn-sm">Save And Add Another</button>
                @else
                    <button type="submit" name="button_type" value="UPDATE" class="btn btn-primary btn-sm">Update</button>
                @endif
                <a href="{{ url($url) }}" class="btn btn-danger btn-sm">Cancel</a>
            </div>
        </div>        <!--CARD-->
        </form>
        </div> <!--COL-->

        <div class="col-md-6">
            @include('Widget.ClientDetailsWidget',['client_detail'=>$client_detail])
        </div>
    </div>


    <div class="row">
        <div class="col-md-6">
            @include('Widget.DocumentListWidget',['documents'=>$documents])
        </div> <!--COL -->
        <div class="col-md-6">
            @include('Widget.CommentWidget',['id'=>$id,'comments'=>$comments])
        </div> <!--COL -->
    </div>
@endsection

@push('scripts')
<script>
</script>
@endpush

