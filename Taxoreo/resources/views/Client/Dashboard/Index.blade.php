@extends('Client.Layout.Master')

@section('css')
<style>
    .custom-file-input{
        border:none !important;
    }
</style>
@endsection

@section('content')


@if(count($new_services))
<div class="row mt-2">
    @foreach($new_services as $s)
        <div class="col-md-3">
            <div class="card">

                <div class="card-header bg-primary text-white p-3 text-center">
                    <h4 class="text-white">{{$s->service_name}}</h4>
                </div>

                <div class="card-body">
                    @if($s->current_stage=="DOCUMENT")
                        @if($s->remaining_documents > 0)
                            <button type="button" class="btn btn-md btn-outline-primary w-100"
                                        data-toggle="modal" data-target="#upload_document_modal_{{$s->id}}"
                                        >
                                    UPLOAD DOCUMENTS
                            </button>
                        @endif

                        @if($s->remaining_documents == 0 )
                            <span class="badge badge-pill badge-warning">
                                    Under document verification
                            </span>
                        @endif

                    @endif

                    @if($s->current_stage=="PAYMENT")

                        @if(!$s->payment_type)
                            <div class="d-flex justify-content-center">
                                <h5>Waiting for payment update !!!</h5>
                            </div>
                        @else
                            @if($s->payment_detail)
                                <?php
                                    $message=null;
                                    $payment=null;

                                    if($s->payment_detail->payment_type  == "ADVANCE_PAYMENT")
                                    {
                                        $message.="To proceed futher please make advance payment of
                                                    <b> Rs. ".$s->payment_detail->payable_amount ."</b>";
                                        $payment=$s->payment_detail->payable_amount;
                                    }

                                    if($s->payment_detail->payment_type == "BALANCE_PAYMENT"
                                        && $s->current_status=="COMPLETE"){
                                        $message.="To proceed futher please pay balance payment of
                                                    <b> Rs. ".$s->payment_detail->payable_amount ."</b>";
                                        $payment=$s->payment_detail->payable_amount;
                                    }

                                    if($s->payment_detail->payment_type=="FULL_PAYMENT")
                                    {
                                        $message.="To proceed futher please complete payment of
                                                <b> Rs. ".$s->payment_detail->payable_amount."</b>";
                                        $payment=$s->payment_detail->payable_amount;
                                    }
                                ?>

                                <small class="text-align-center"><i>{!!$message!!}</i></small>

                                @if($payment)
                                    <form action="{{ url('make-payment') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_added_service_id" value="{{$s->id}}">
                                        <button type="submit" class="btn btn-md btn-outline-primary w-100">
                                                PAY Rs. {{$payment}}
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endif
                    @endif

                    @if($s->current_stage=="WORK_IN_PROGRESS")

                        @if(!$s->assigned_to_user_id)
                            <div class="row" style="font-size:14px">
                                <div class="col-md-12 text-center text-weight-bold">
                                    <p>We will shortly assign executive to handle your service request.</p>
                                </div>
                            </div>
                        @endif

                        @if($s->assigned_to_user_id)

                            @if(!$s->current_status)
                                <div class="row" style="font-size:14px">
                                    <div class="col-md-12 text-center text-weight-bold">
                                        <p>Processing will begin shortly.</p>
                                    </div>
                                </div>
                            @endif

                            @if($s->current_status)
                                <div class="row" style="font-size:14px">
                                    <div class="col-md-12 text-center text-weight-bold">
                                        <p>Process is started !!!</p>
                                    </div>
                                </div>
                            @endif

                        @endif

                    @endif
                </div>
            </div>
        </div>


        <div class="modal fade" id="upload_document_modal_{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="{{ url('client/dashboard') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="master_service_id" value="{{$s->master_service_id}}">
                    <div class="modal-body p-2">
                        <div class="row mt-0 pt-0">
                            @if(count($s->documents))
                            @foreach($s->documents as $d)
                                <div class="col-md-4">
                                    <div class="card  shadow-none border">
                                        <div class="card-header text-center p-2">
                                            <h5 class="font-weight-bold">
                                                @if($d->uploaded_document_path)
                                                        {{-- <i class="far fa-check-circle" style="color:green"></i> --}}

                                                        {{-- <i class="fas fa-times-circle"></i> --}}
                                                @endif
                                                {{$d->document_name}}
                                            </h5>
                                                @if($d->uploaded_document_status)
                                                    <div class="p-1">
                                                        @if($d->uploaded_document_status=="ACCEPTED")
                                                            <span class="badge badge-pill badge-success">
                                                                {{$d->uploaded_document_status}}
                                                            </span>
                                                        @elseif($d->uploaded_document_status=="IN_REVIEW")
                                                            <span class="badge badge-pill badge-warning">
                                                                {{$d->uploaded_document_status}}
                                                            </span>
                                                        @else
                                                            <span class="badge badge-pill badge-danger">
                                                                {{$d->uploaded_document_status}}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    @if($d->document_note)
                                                        <p class="p-0 m-0" style="font-size:14px;font-weight:600;color:red">
                                                        {{$d->document_note}}
                                                        </p>
                                                    @endif
                                                @endif

                                                @if($d->uploaded_document_path && !$d->uploaded_document_status)
                                                    <div class="d-flex justify-content-center p-1">
                                                        <span class="badge badge-pill badge-warning">
                                                            Waiting for response !!!
                                                        </span>
                                                    </div>
                                                @endif
                                        </div>

                                    @if(!$d->uploaded_document_status || $d->uploaded_document_status=="REJECTED")
                                        <div class="card-body text-lg-left text-center p-1">
                                            @if($d->uploaded_document_path && !$d->uploaded_document_status)
                                                <div class="d-flex justify-content-center p-1">
                                                    <span class="badge badge-pill badge-success">
                                                        Uploaded
                                                    </span>
                                                </div>
                                            @endif

                                            @if(!$d->uploaded_document_path || $d->uploaded_document_status=="REJECTED")
                                                <input type="hidden" name="service_no" value="{{$s->service_no}}">
                                                <input type="hidden" name="service_id" value="{{$s->id}}">

                                                <input type="hidden" name="document_id[]" value="{{$d->uploaded_document_id}}">

                                                <div class="file-input d-flex justify-content-center">
                                                    <input type="file" class="custom_upload"
                                                            id="upload_box_for_{{$s->id}}_{{$d->master_document_id}}"
                                                            name="upload_box[]"
                                                            title=" "
                                                            lang="en"
                                                            onchange="get_file_name({{$s->id}},{{$d->master_document_id}},event)"
                                                            >
                                                    <label for="upload_box_for_{{$s->id}}_{{$d->master_document_id}}">Select file</label>
                                                </div>

                                                <div class="d-flex justify-content-center">
                                                    <span id="uploaded_file_name_{{$s->id}}_{{$d->master_document_id}}"></span>
                                                </div>
                                            @endif

                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer mt--5">
                    <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>

                        <?php
                            if(count($s->documents)){
                                $show=1;
                                foreach($s->documents as $d){
                                    if(!$d->uploaded_document_name){
                                        $show=1;
                                        break;
                                    }
                                }
                                if($show==1){
                                    echo '<button type="submit" class="btn btn-primary btn-md">Upload</button>';
                                }
                            }
                        ?>
                    </div>
                </form>
              </div>
            </div>
          </div>
    @endforeach
</div>
@endif

    @if(count($current_services))
        <div class="row">
            @foreach($current_services as $s)
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header bg-primary text-white p-3 text-center">
                            <h4 class="text-white">{{$s->service_name}}</h4>
                        </div>
                        <span class="badge badge-pill badge-success"
                              style="position: absolute;margin-top:20%;left:37%"
                              >
                            Active
                        </span>
                        <div class="card-body">
                            <table class="table">

                                <tr class="p-0">
                                    <td class="p-1 service-card-table-label">Service No :</td>
                                    <td class="p-1 service-card-table-value">{{$s->service_no}}</td>
                                </tr>

                                <tr class="p-0">
                                    <td class="p-1 service-card-table-label">Assign To :</td>
                                    <td class="p-1 service-card-table-value">{{$s->assign_to_user_name}}</td>
                                </tr>

                                <tr class="p-0">
                                    <td class="p-1 service-card-table-label">Current Status :</td>
                                    <td class="p-1 service-card-table-value">{{$s->current_status}}</td>
                                </tr>
                                @if($s->documents_uploaded!=0)
                                    <tr class="p-0">
                                        <td class="p-1 service-card-table-label">Doc :</td>
                                        <td class="p-1 service-card-table-value">{{$s->documents_uploaded}}</td>
                                    </tr>
                                @else

                                @endif
                            </table>
                        </div>

                        @if($s->documents_uploaded==0)
                            <span class="badge badge-pill badge-danger"
                                    data-toggle="modal" data-target="#upload_document_modal_{{$s->id}}"
                                    style="position: absolute;margin-top:75%;left:10%;font-size:15px;width:80%;text-align:center"
                                    >
                                UPLOAD DOCUMENT
                            </span>
                        @endif

                    </div>
                </div>


                <div class="modal fade" id="upload_document_modal_{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Upload Document</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="{{ url('client/dashboard') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="master_service_id" value="{{$s->master_service_id}}">
                            <div class="modal-body p-2">
                                <div class="row mt-0 pt-0">
                                    @if(count($s->documents))
                                    @foreach($s->documents as $d)
                                        <div class="col-md-4">
                                            <div class="card  shadow-none border">
                                                <div class="card-header text-center p-2">
                                                    <h5 class="font-weight-bold">
                                                        {{$d->document_name}}
                                                    </h5>
                                                </div>
                                                <div class="card-body text-lg-left text-center p-1">
                                                    @if($d->uploaded_document_name)
                                                        <div class="d-flex justify-content-center p-1">
                                                            <span class="badge badge-pill badge-success">
                                                                Uploaded
                                                            </span>
                                                        </div>
                                                    @endif

                                                    @if(!$d->uploaded_document_name)

                                                        <input type="hidden" name="service_no" value="{{$s->service_no}}">
                                                        <input type="hidden" name="document_name[{{$d->master_document_id}}]" value="{{$d->document_name}}">

                                                        <div class="file-input d-flex justify-content-center">
                                                            <input type="file" class="custom_upload"
                                                                    id="upload_box_for_{{$s->id}}_{{$d->master_document_id}}"
                                                                    name="upload_box[{{$d->master_document_id}}]"
                                                                    title=" "
                                                                    lang="en"
                                                                    onchange="get_file_name({{$s->id}},{{$d->master_document_id}},event)"
                                                                    >
                                                            <label for="upload_box_for_{{$s->id}}_{{$d->master_document_id}}">Select file</label>
                                                        </div>

                                                        <div class="d-flex justify-content-center">
                                                            <span id="uploaded_file_name_{{$s->id}}_{{$d->master_document_id}}"></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer mt--5">
                            <button type="button" class="btn btn-secondary btn-md" data-dismiss="modal">Close</button>

                                <?php
                                    if(count($s->documents)){
                                        $show=1;
                                        foreach($s->documents as $d){
                                            if(!$d->uploaded_document_name){
                                                $show=1;
                                                break;
                                            }
                                        }
                                        if($show==1){
                                            echo '<button type="submit" class="btn btn-primary btn-md">Upload</button>';
                                        }
                                    }
                                ?>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>
            @endforeach
        </div>
    @endif

@endsection
@push('scripts')
<script>

    function get_file_name(service_id,doc_id, e){
        $('#uploaded_file_name_'+service_id+'_'+doc_id).text('');
        $('#uploaded_file_name_'+service_id+'_'+doc_id).text(e.target.files[0].name);
    }

    function show_upload_document_modal(user_service_id,master_service_id){
        $('#upload_document_modal').modal('show');
    }
</script>
@endpush
