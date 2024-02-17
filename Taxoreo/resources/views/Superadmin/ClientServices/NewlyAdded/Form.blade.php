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
                    Service Name :
                </label>
            </div>
            <div class="col-md-6">
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


        @if($user_service->current_stage=="PAYMENT")
            <div class="row m-0">
                <div class="col-md-3 text-right">
                    <label class="form-control-label">
                        Payment Type :
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control form-control-sm"
                            id="payment_type"
                            name="payment_type"
                            onchange="changePaymentType(this.value)">
                            @if(!$user_service->payment_type)
                                <option value="">Select Payment Type</option>
                            @endif
                            <option value="FULL_PAYMENT"
                                @if($user_service->payment_type && $user_service->payment_type=="FULL_PAYMENT")
                                    selected
                                @endif
                            >Full Payment</option>
                            <option value="ADVANCE_PAYMENT"
                                @if($user_service->payment_type && $user_service->payment_type=="ADVANCE_PAYMENT")
                                    selected
                                @endif
                            >Advance Payment</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-3 text-right">
                    <label class="form-control-label">
                        Total Amount :
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm"
                            id="total_amount"
                            name="total_amount"
                            value="{{$user_service->total_amount}}"
                            readonly
                            >
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-3 text-right">
                    <label class="form-control-label">
                        Advance Amount :
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm"
                            id="total_advance_amount"
                            name="total_advance_amount"
                            value="{{$user_service->total_advance_amount}}"
                            readonly
                            oninput="balance_calc(this.value)"
                            >
                    </div>
                </div>
            </div>

            <div class="row m-0">
                <div class="col-md-3 text-right">
                    <label class="form-control-label">
                        Balance Amount :
                    </label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control form-control-sm"
                            id="total_balance_amount"
                            name="total_balance_amount"
                            value="{{$user_service->total_balance_amount}}"
                            readonly
                            >
                    </div>
                </div>
            </div>
        @endif

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

    @if($id)
        <form action="{{ url($doc_url.'/'.$id)}}" method="post"
            enctype="multipart/form-data"
        >
            <input type="hidden" name="_method" value="PUT">
        @csrf
            <div class="card card-body">
                <table class="table table-border">
                    <thead class="thead-light">
                        <th>Sr</th>
                        <th>Doc Name</th>
                        <th>Check Doc</th>
                        <th>Status</th>
                        <th>Remark</th>
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
                                                >
                                                View
                                            </a>
                                        @else
                                            NOT UPLAODED
                                        @endif
                                    </td>
                                    <td class="p-1">
                                        @if($u->document_path)
                                            <select class="form-control form-control-sm"
                                                id="document_status_{{$u->id}}"
                                                name="document_status[{{$u->id}}]"
                                            >
                                                @if(!$u->document_status)
                                                    <option value="">Select Status</option>
                                                @endif
                                                <option value="ACCEPTED"
                                                @if($u->document_status && $u->document_status=="ACCEPTED")
                                                    selected
                                                @endif
                                                >Accepted</option>
                                                <option value="REJECTED"
                                                @if($u->document_status && $u->document_status=="REJECTED")
                                                    selected
                                                @endif
                                                >Rejected</option>
                                                <option value="IN_REVIEW"
                                                @if($u->document_status && $u->document_status=="IN_REVIEW")
                                                    selected
                                                @endif
                                                >In Review</option>
                                            </select>
                                        @endif
                                    </td>
                                    <td class="p-1">
                                        @if($u->document_path)
                                        <input type="text" class="form-control form-control-sm input_text alpha"
                                            id="document_note"
                                            name="document_note[{{$u->id}}]"
                                            placeholder="Document Note"
                                        >
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <div class="p-0 p-0 text-right">
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
    @endif
@endsection

@push('scripts')
<script>
function changePaymentType(payment_type){
    if(payment_type=="ADVANCE_PAYMENT"){
        $('#total_advance_amount').attr('readonly',false);
        $('#total_advance_amount').val(0);
    }

    if(payment_type=="FULL_PAYMENT"){
        $('#total_advance_amount').attr('readonly',true);
        $('#total_advance_amount').val(0);
        var total_amount=$('#total_amount').val();
        $('#total_balance_amount').val(total_amount);
    }
}

function balance_calc(total_advance_amount){

    var total_amount=$('#total_amount').val();
    var total_balance_amount=total_amount;

    var payment_type=$('#payment_type').val();
    if(payment_type=="ADVANCE_PAYMENT")
    {
        if(total_advance_amount && total_advance_amount>=0 && total_amount > total_advance_amount){
            total_balance_amount=total_amount-total_advance_amount;
        }
    }
    $('#total_balance_amount').val(total_balance_amount);
}

</script>
@endpush

