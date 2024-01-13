
@extends('Website.Layout.app')
@section('content')
    <!-- Page Banner Section -->
        <section class="page-banner" style="height:10px !important;padding:160px 0px 100px !important;">
            <h1>Blog</h1>
        </section>
    <!--End Banner Section -->

    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="news-block-two blog-single-post">
                        <div class="inner-box">
                            <div class="lower-content">
                                <ul class="post-meta">

                                    <li>
                                        <i class="far fa-calendar-alt"></i> {{date('jS M y',strtotime($blog->created_at))}}
                                    </li>
                                </ul>
                                <h2>{{$blog->blog_title}}</h2>
                                <div class="text" style="text-align: justify">
                                    <p><?php echo $blog->description; ?></p>
                                </div>
                                @if($previous || $next)
                                <div class="blog-post-pagination">
                                    <div class="wrapper-box">
                                        @if($previous)
                                            <div class="next-post">
                                                <h6> Previous Post</h6>
                                                <h5><?php echo substr_replace(strip_tags($previous->blog_title), "...",30)	?></h5>
                                            </div>
                                        @endif

                                        <div class="page-view"><span class="fa fa-th"></span></div>

                                        @if($next)
                                            <div class="next-post">
                                                <h6> Previous Post</h6>
                                                <h5><?php echo substr_replace(strip_tags($next->blog_title), "...",30)	?></h5>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection

    @push('scripts')
        <script>

        </script>
    @endpush
