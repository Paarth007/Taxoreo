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
            <div class="card card-body">
                <div class="row m-0">
                    <div class="col-md-4 text-right">
                        <label class="form-control-label">
                            Client Name :
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <p class="text-bold"><b>{{$user_service->client_name}}</b></p>
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-4 text-right">
                        <label class="form-control-label">
                            Service Assign on :
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <p class="text-bold"><b>{{date("d-M-Y",strtotime($user_service->assigned_at))}}</b></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    @if($id)
            <div class="card card-body">
                <table class="table table-border">
                    <thead class="thead-light">
                        <th>Sr</th>
                        <th>Doc Name</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @if(count($user_documents))
                            @foreach($user_documents as $u)
                                <tr class="p-1">
                                    <td class="p-1">{{$loop->iteration}}</td>
                                    <td class="p-1">{{$u->document_name}}</td>
                                    <td class="p-1">
                                        @if($u->document_path)
                                            <a href="{{ url($u->document_path) }}"
                                                target="_blank"
                                                class="btn btn-primary btn-sm"
                                                >
                                                View
                                            </a>

                                            <a href="{{ url($u->document_path) }}"
                                                download
                                                class="btn btn-danger btn-sm"
                                                >
                                                Download
                                            </a>
                                        @else
                                            NOT UPLAODED
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>


            </div>

    @endif
@endsection

@push('scripts')
<script>
</script>
@endpush

