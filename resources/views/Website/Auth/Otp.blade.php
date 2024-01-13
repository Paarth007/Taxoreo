
@extends('Website.Layout.app')
@section('content')
 <section class="page-banner" style="height:50px">
    <div class="image-layer lazy-image"
        data-bg="{{ url('website/images/background/image-11.jpg') }}">
    </div>
    <div class="bottom-rotten-curve alternate"></div>
    <div class="auto-container">
        <h1>Verify Yourself</h1>
    </div>
</section>
<!--End Banner Section -->

<section class="checkout-area" >
    <div class="auto-container" style="margin-top:-100px">
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="form billing-info">
                    <div class="shop-title-box">
                        <h3>Verify OTP</h3>
                    </div>
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if (Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }} text-white p-1" style="color:#ffff;">
                                <b>{{ Session::get('alert-' . $msg) }} </b>
                                <a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>
                            {{ session()->forget('alert-' . $msg) }}
                        @endif
                    @endforeach
                    {{Session::get('otp')}}
                    <form method="post" action="{{url('Auth/otp')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-label">Contact No </div>
                                <div class="field-input">
                                    <input type="text" name="mobile_no" placeholder="Mobile Number"
                                        value="{{Session::get('mobile_no')}}"
                                        readonly
                                    >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-label">OTP *</div>
                                <div class="field-input">
                                    <input type="text" name="otp">
                                </div>
                            </div>
                        </div>

                        <button class="theme-btn btn-style-one" type="submit">
                            <span class="btn-title">Verify OTP</span>
                        </button>
                    </form>
                </div>
            </div> <!--COL-->
        </div>
    </div>
</section>
@endsection

@push('scripts')
    <script>

    </script>
@endpush
