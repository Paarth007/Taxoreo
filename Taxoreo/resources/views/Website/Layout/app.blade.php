<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>TAXOREO</title>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="google-site-verification" content="ZWj8pGkgZq1TNevS_DJwSSaA8IIrzbK11NaNE7gRj7U" />
<meta name="facebook-domain-verification" content="zod4zkue2175cc65xucdzbtqlu7m32" />
<title>GST ,Income Tax  Return Filling  and other  Service | Taxoeo </title>
<meta name="keywords" content="GST Return filling, Income tax return filling, GST Registration, PAN registration, Payroll,  EPF, ESIC, Professional Tax, Income tax, Udyog Aadhar, Gumasta, Project Report, CMA Data, Balance Sheet, Profit & Loss Account, Taxation, Business Support Services">
<meta name="description" content="GST Registration, GST Filing, Income Tax filing in India.  Project Report, CMA Data and  support  services,  Simplify your compliance and tax filing with Taxoreo.">
<meta name="Robots" content="NOINDEX,NOFOLLOW">
<link rel="canonical" href="https://www.taxoreo.com/" />

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@taxoreo">
<meta name="twitter:title" content="taxoreo -GST and Income Tax and Business support Services">
<meta name="twitter:description" content="GST Return Filing, GST Registration, Income Tax filing. EPF, ESIC, Prof Tax, Udyog Aadhar, Gumasta, Project Report, and  support  services,  Simplify your compliance and tax filing with Taxoreo.">
<meta name="twitter:creator" content="@taxoreo">
<meta name="twitter:image" content="https://www.taxoreo.com/images/taxoreo.jpg">

<meta property="og:title" content="taxoreo - GST and Income Tax Professional Services" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://www.taxoreo.com/" />
<meta property="og:image" content="https://www.taxoreo.com/images/taxoreo.jpg" />
<meta property="og:description" content="GST Return Filing, GST Registration, Income Tax filing. EPF, ESIC, Prof Tax, Udyog Aadhar, Gumasta, Project Report, and  support services, Simplify your compliance and tax filing with Taxoreo." />
<meta property="og:site_name" content="taxoreo" />
<meta property="fb:admins" content="2170888566632790" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">


<link href="{{ url('website/css/bootstrap.css') }} " rel="stylesheet">
<link href="{{ url('website/css/style.css') }}" rel="stylesheet">
<link href="{{ url('website/css/responsive.css') }}" rel="stylesheet">
<link href="{{ url('website/css/custom.css') }}" rel="stylesheet">
<link href="{{ url('website/css/color.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="{{ url('website/images/favicon.png') }}" type="image/x-icon">
<link rel="icon" href="{{ url('website/images/favicon.png') }}" type="image/x-icon">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-QR89FR85S7"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-QR89FR85S7');
</script>

<?php
    $menu=DB::table('website_menu_services')->where('is_active',1)
                                            ->select('menu_service_name','id')
                                            ->get();
    $menuArray=[];
    foreach($menu as $m){
        $submenus=DB::table('website_submenu_services')
                                            ->where('website_menu_service_id',$m->id)
                                            ->where('is_active',1)
                                            ->select('id','menu_name','redirection_url')
                                            ->get();
        $submenusArray=[];
        if(count($submenus)){
            foreach($submenus as $sm){
                $tempSubmenu=[];
                $tempSubmenu['id']=$sm->id;
                $tempSubmenu['menu_name']=$sm->menu_name;
                $tempSubmenu['redirection_url']=$sm->redirection_url;
                $submenusArray[]=$tempSubmenu;
            }
        }
        $temp=[];
        $temp['id']=$m->id;
        $temp['menu_name']=$m->menu_service_name;
        $temp['sub_menus']=$submenusArray;
        $menuArray[]=$temp;
    }
?>


</head>
<body>
    <div class="page-wrapper">

        <header class="main-header header-style-two">
            <!-- Header Top Two -->
            <div class="header-top-two">
                <div class="auto-container">
                    <div class="inner">
                        <div class="top-left">

                        </div>

                        <div class="top-middile">
                            <ul class="contact-info">
                                <li><a href="mailto:info@webmail.com"><i class="far fa-envelope"></i>info@taxoreo.com</a></li>
                                <li><a href="tel:+9404088555"><i class="far fa-phone"></i>+9404088555</a></li>
                            </ul>
                        </div>

                        <div class="top-right">

                            {{-- <ul class="social-links clearfix">
                                <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                                <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                <li><a href="#"><span class="fab fa-behance"></span></a></li>
                                <li><a href="#"><span class="fab fa-linkedin"></span></a></li>
                                <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Upper -->
            <div class="header-upper" style="margin-top:-30px !important;width:100% !important">
                <div class="">
                    <div class="inner-container">
                        <!--Nav Box-->
                        <div class="nav-outer clearfix">
                            <!--Logo-->
                            <div class="logo-box">
                                <div class="logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ url('website/images/logo/header-logo.png') }}" alt=""
                                        style="width:180px;"
                                        >
                                    </a>
                                </div>
                            </div>
                            <!--Mobile Navigation Toggler-->
                            <div class="mobile-nav-toggler"><span class="icon fal fa-bars"></span></div>

                            <!-- Main Menu -->
                            <nav class="main-menu navbar-expand-md navbar-light">
                                <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                    <ul class="navigation clearfix">
                                        <li><a href="{{url('/')}}">Home</a></li>
                                        <li><a href="{{ url('about-us') }}">About Us</a></li>
                                        @if(count($menuArray))
                                        <li class="dropdown"><a href="#">Services</a>
                                            <ul>
                                                @foreach($menuArray as $m)
                                                    @if(count($m['sub_menus'])==0)
                                                        <li class="p-0">
                                                            <a href="#">{{$m['menu_name']}}</a>
                                                        </li>
                                                    @else
                                                        <li class="dropdown p-0">
                                                            <a href="#">{{$m['menu_name']}}</a>
                                                            @foreach($m['sub_menus'] as $sm)
                                                                <ul>
                                                                    <li>
                                                                        <a href="{{url('service/'.$sm["redirection_url"])}}">{{$sm['menu_name']}}</a>
                                                                    </li>
                                                                </ul>
                                                            @endforeach
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endif
                                        <li><a href="{{url('blog')}}">Blogs</a></li>
                                        <li><a href="{{url('contact-us')}}">Contact</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <!-- Main Menu End-->

                            <!-- Link Btn-->
                            {{-- <div class="link-btn"><a href="#" class="theme-btn btn-style-one"><span class="btn-title">Get A Quote</span></a></div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--End Header Upper-->

            <!-- Sticky Header  -->
            <div class="sticky-header">
                <div class="auto-container clearfix">
                    <!--Logo-->
                    <div class="logo pull-left">
                        <a href="{{ url('/') }}" title="">
                            <img src="{{ url('website/images/logo/sticky-logo.png') }}" alt="">
                        </a>
                    </div>
                    <!--Right Col-->
                    <div class="pull-right">
                        <!-- Main Menu -->
                        <nav class="main-menu clearfix">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav><!-- Main Menu End-->
                    </div>
                </div>
            </div><!-- End Sticky Menu -->

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="icon flaticon-cancel"></span></div>

                <nav class="menu-box">
                    <div class="nav-logo"><a href="{{ url('/') }}"><img src="assets/images/logo.png" alt="" title=""></a></div>
                    <div class="menu-outer"><!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
                    <!--Social Links-->
                    <div class="social-links">
                        <ul class="clearfix">
                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fab fa-facebook-square"></span></a></li>
                            <li><a href="#"><span class="fab fa-pinterest-p"></span></a></li>
                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                            <li><a href="#"><span class="fab fa-youtube"></span></a></li>
                        </ul>
                    </div>
                </nav>
            </div><!-- End Mobile Menu -->
        </header>
                @yield('content')

        	<!-- Main Footer -->
            <footer class="main-footer mt-5">
                <div class="auto-container">
                    <!--Widgets Section-->
                    <div class="widgets-section">
                        <div class="row clearfix">

                            <!--Column-->
                            <div class="column col-lg-4">
                                <div class="footer-widget logo-widget">
                                    <div class="widget-content">
                                        <div class="footer-logo">
                                            <a href="{{ url('/') }}"><img class="lazy-image" src="assets/images/resource/image-spacer-for-validation.png" data-src="assets/images/footer-logo.png" alt="" /></a>
                                        </div>
                                        <div class="text" style="text-align:justify;color:black">
                                            Taxoreo.com is Owned and operated by Advanced Institute of Accounts and Taxation Pvt Ltd, This company has been providing accounting and taxation training and services from 10 years.

                                        </div>
                                        <ul class="social-links clearfix">
                                            <li><a href="#"><span class="fab fa-facebook-f"></span></a></li>
                                            <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                                            <li><a href="#"><span class="fab fa-vimeo-v"></span></a></li>
                                            <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column col-lg-4">
                                <div class="footer-widget links-widget">
                                    <div class="widget-content">
                                        <h3>Links</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul>
                                                    <li><a href="#">Home</a></li>
                                                    <li><a href="#">About</a></li>
                                                    <li><a href="#">Services</a></li>
                                                    <li><a href="#">Portfolio</a></li>
                                                    <li><a href="#">Pricing</a></li>
                                                    <li><a href="#">Contact</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Column-->
                            <div class="column col-lg-4">
                                <div class="footer-widget links-widget">
                                    <div class="widget-content">
                                        <h3>Our Policy</h3>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul>
                                                    <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                                                    <li><a href="{{ url('return-policy') }}">Return Policy</a></li>
                                                    <li><a href="{{ url('refund-policy') }}">Refund Policy</a></li>
                                                    <li><a href="{{ url('terms-and-conditions') }}">Terms & Conditions</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Footer Bottom -->
                <div class="auto-container">
                    <div class="footer-bottom">
                        <div class="">copyright by <a href="#">www.taxoreo.com </a> @ {{date('Y')}}</div>
                    </div>
                </div>
            </footer>
    </div>


    @stack('scripts')

    <script src="{{ url('website/js/jquery.js') }}"></script>
    <script src="{{ url('website/js/popper.min.js') }}"></script>
    <script src="{{ url('website/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('website/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ url('website/js/jquery.fancybox.js') }}"></script>
    <script src="{{ url('website/js/isotope.js') }}"></script>
    <script src="{{ url('website/js/owl.js') }}"></script>
    <script src="{{ url('website/js/appear.js') }}"></script>
    <script src="{{ url('website/js/wow.js') }}"></script>
    <script src="{{ url('website/js/lazyload.js') }}"></script>
    <script src="{{ url('website/js/scrollbar.js') }}"></script>
    <script src="{{ url('website/js/TweenMax.min.js') }}"></script>
    <script src="{{ url('website/js/script.js') }}"></script>

    </body>
    </html>
