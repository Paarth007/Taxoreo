
@extends('Website.Layout.app')
@section('content')
    <!-- Page Banner Section -->
        <section class="page-banner" style="height:10px !important;padding:160px 0px 100px !important;">
            <h1>Contact Us</h1>
        </section>
    <!--End Banner Section -->

    <section class="map-section">
        <div class="map-column">
            <div class="map-canvas"
                data-zoom="12"
                data-lat="-37.817085"
                data-lng="144.955631"
                data-type="roadmap"
                data-hue="#ffc400"
                data-title="Envato"
                data-icon-path="assets/images/icons/map-marker.png"
                data-content="Melbourne VIC 3000, Australia<br><a href='mailto:info@youremail.com'>info@youremail.com</a>">
            </div>
        </div>
    </section>

    <section class="contact-section-two">
        <div class="auto-container">
            <div class="contact-info-area">
                <div class="contact-info">
                    <div class="row">
                        <div class="info-column col-lg-4">
                            <div class="icon-box">
                                <div class="icon"><span class="flaticon-email-6"></span></div>
                                <h3>Email Address</h3>
                                <ul>
                                    <li><a href="mailto:info@webmail.com">info@webmail.com</a></li>
                                    <li><a href="mailto:info@webmail.com">jobs@exampleco.com</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="info-column col-lg-4">
                            <div class="icon-box">
                                <div class="icon"><span class="flaticon-call-1"></span></div>
                                <h3>Phone Number</h3>
                                <ul>
                                    <li><a href="tel:+8976765654654">+897 676 5654 654</a></li>
                                    <li><a href="tel:+908(097)56476576">+908(097) 564 765 76</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="info-column col-lg-4">
                            <div class="icon-box">
                                <div class="icon"><span class="flaticon-location"></span></div>
                                <h3>Office Address</h3>
                                <ul>
                                    <li>12/A, Romania City Town Hall <br>New Joursey, UK</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-form-area" id="contact-form-section">
                <div class="sec-title text-center">
                    <div class="sub-title">Write Here</div>
                    <h2>Get In Touch</h2>
                </div>
                <!-- Contact Form-->
                <div class="contact-form" >
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if (Session::has('alert-' . $msg))
                            <p class="alert alert-{{ $msg }} text-white p-1" style="color:#ffff;">
                                <b>{{ Session::get('alert-' . $msg) }} </b>
                                <a href="#" class="close text-white" data-dismiss="alert" aria-label="close">&times;</a>
                            </p>
                            {{ session()->forget('alert-' . $msg) }}
                        @endif
                    @endforeach

                    <form method="post" action="{{url('contact-us')}}" id="contact-form">
                        @csrf
                        <div class="row clearfix">
                            <div class="col-md-12 form-group">
                                <label for="name">Enter your name</label>
                                <input type="text" name="name" id="name" placeholder="Enter name here......" required="">
                                <i class="fas fa-user"></i>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="email">Enter your email</label>
                                <input type="email" name="email" id="email" placeholder="Enter email here......" required="">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="mobile_no">Enter your mobile no</label>
                                <input type="text" name="mobile_no" id="mobile_no" placeholder="Enter mobile no here......" required="">
                                <i class="fas fa-envelope"></i>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="message">Enter your message</label>
                                <textarea name="message" id="message" placeholder="Enter message here......"></textarea>
                                <i class="fas fa-edit"></i>
                            </div>

                            <div class="col-md-12 form-group">
                                <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="btn-title">Get In Touch</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @endsection

    @push('scripts')
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcaOOcFcQ0hoTqANKZYz-0ii-J0aUoHjk"></script>
        <script src="{{url('website/js/map-script.js')}}"></script>
    @endpush
