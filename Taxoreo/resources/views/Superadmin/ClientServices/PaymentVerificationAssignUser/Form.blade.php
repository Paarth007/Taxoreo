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
                            Current Stage :
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm"
                                id=""
                                name=""
                                value="{{$user_service->current_stage}}"
                                readonly
                                >
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-4 text-right">
                        <label class="form-control-label">
                            Assign To :
                        </label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <select class="form-control form-control-sm"
                                name="assigned_to_user_id"
                                id="assigned_to_user_id"
                            >
                                <option value="">Select User</option>
                                <?php
                                if(count($freelancers)){
                                    foreach($freelancers as $f){
                                        $selected="";
                                        if($user_service->assigned_to_user_id && $user_service->assigned_to_user_id==$f->id){
                                            $selected="selected";
                                        }
                                        echo '<option value="'.$f->id.'" '.$selected.'>'.$f->freelancer_name.'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-4 text-right">
                        <label class="form-control-label">
                            Status :
                        </label>
                    </div>
                    <div class="col-md-8 text-left d-flex justify-content-start" style="font-size:14px;">
                        <div class="">
                            <input type="radio"
                                id="is_active_1"
                                name="is_active"
                                value="1"
                                {{$user_service ? ($user_service->is_active==1 ? "checked" :"") : "checked" }}
                                >
                                Active
                        </div>
                        <div class="form-group ml-3">
                            <input type="radio"
                                id="is_active_0"
                                name="is_active"
                                value="0"
                                {{$user_service && $user_service->is_active==0 ? "checked" :"" }}
                                >
                                Deactive
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-4 text-right">
                        <label class="form-control-label">
                            Remark :
                        </label>
                    </div>
                    <div class="col-md-8 text-left">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm input_text alpha"
                                id="remark"
                                name="remark"
                                value="{{$user_service ? $user_service->remark:"" }}"
                                >
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
        </div><!--COL-->

        <div class="col-md-6">
            <div class="card card-body">
                <div class="row m-0">
                    <div class="col-md-3 text-right">
                        <label class="form-control-label">
                            Total Amount :
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm"
                                id=""
                                name=""
                                value="{{$user_service->total_amount}}"
                                readonly
                                >
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-3 text-right">
                        <label class="form-control-label">
                            Paid Amount :
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm"
                                id=""
                                name=""
                                value="{{$user_service->total_paid_amount}}"
                                readonly
                                >
                        </div>
                    </div>
                </div>

                <div class="row m-0">
                    <div class="col-md-3 text-right">
                        <label class="form-control-label">
                            Bal. Amount :
                        </label>
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-sm"
                                id=""
                                name=""
                                value="{{$user_service->total_paid_amount}}"
                                readonly
                                >
                        </div>
                    </div>
                </div>
            </div> <!--CARD-->

            @if(count($payments))
            <div class="card card-body">
                <div class="table-responsive">
                    <table class="table table-borderd">
                        <thead class="">
                            <th class="p-1">Sr</th>
                            <th class="p-1">Payment Type</th>
                            <th class="p-1">Payable Amt</th>
                            <th class="p-1">Paid Amt</th>
                            <th class="p-1">Tans Id</th>
                            <th class="p-1">Tans At</th>
                        <thead>
                        @foreach($payments as $p)
                            <tr>
                                <td class="p-1">{{$loop->iteration}}</td>
                                <td class="p-1">{{$p->payment_type}}</td>
                                <td class="p-1">{{$p->payable_amount}}</td>
                                <td class="p-1">{{$p->paid_amount}}</td>
                                <td class="p-1">{{$p->transaction_id}}</td>
                                <td class="p-1">{{$p->addedon}}</td>
                            </tr>
                        @endforeach
                </table>
            </div>
            @endif
        </div> <!--COL-->

    </div>
@endsection

@push('scripts')
<script>
function changePaymentType(payment_type){

    if(payment_type=="ADVANCE_PAYMENT"){
        $('#advance_amount').attr('readonly',false);
        $('#advance_amount').val(0);
    }

    if(payment_type=="FULL_PAYMENT"){
        $('#advance_amount').attr('readonly',true);
        $('#advance_amount').val(0);
    }
}
</script>
@endpush

