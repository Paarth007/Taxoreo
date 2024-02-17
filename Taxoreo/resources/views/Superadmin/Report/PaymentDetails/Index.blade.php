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
                                <a href="#"><i class="fas fa-home text-primary"></i>Payment Details</a>
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
    <div class="card mt-0">
        <div class="card-body pt-0 m-0">
            @foreach($payment_details as $key=>$value)
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-control-label">{{ $key}} :</label>
                        </div>
                        <div class="col-md-6">
                            <span style="font-size:13px">{{$value}}</span>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
<script>
</script>
@endpush
