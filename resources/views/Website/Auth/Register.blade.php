
@extends('Website.Layout.app')
@section('content')
 <section class="page-banner">
    <div class="image-layer lazy-image"
        data-bg="{{ url('website/images/background/image-11.jpg') }}">
    </div>
    <div class="bottom-rotten-curve alternate"></div>
    <div class="auto-container">
        <h1>Register</h1>
    </div>
</section>
<!--End Banner Section -->

<section class="checkout-area">
    <div class="auto-container" style="margin-top:-100px">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <p class="alert alert-{{ $msg }} text-white p-1" style="color:#ffff;">
                            <b>{{ Session::get('alert-' . $msg) }} </b>
                            <a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
                        </p>
                        {{ session()->forget('alert-' . $msg) }}
                    @endif
                @endforeach

                <div class="form billing-info">
                    <div class="shop-title-box">
                        <h3>Register</h3>
                    </div>
                    <form method="post" action="{{url('Auth/register')}}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="field-label">Company Type *</div>
                                <div class="field-input">
                                    <select
                                        class="form-control"
                                        name="company_type_id">
                                        <option value="">Select Company Type</option>
                                        @foreach ($company_types as $c)
                                            <option value="{{$c->id}}">{{$c->company_type_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-label">First Name*</div>
                                <div class="field-input">
                                    <input type="text" name="first_name" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field-label">Last Name *</div>
                                <div class="field-input">
                                    <input type="text" name="last_name" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="field-label">Contact Info *</div>
                                <div class="field-input">
                                    <input type="text" name="email" placeholder="Email Address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="field-input">
                                    <input type="text" name="mobile_no" placeholder="Mobile Number">
                                </div>
                            </div>
                        </div>

                            <button class="theme-btn btn-style-one" type="submit">
                                <span class="btn-title">Register</span>
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
