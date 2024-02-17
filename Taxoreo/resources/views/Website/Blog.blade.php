
@extends('Website.Layout.app')
@section('content')
    <!-- Page Banner Section -->
    <section class="page-banner" style="height:10px !important;padding:160px 0px 100px !important;">
            <h1>Blogs</h1>
    </section>
    <!--End Banner Section -->

    <section class="news-section mt--2">
        <div class="auto-container">
            <div class="row">

                @foreach($blogs as $b)
                    <div class="news-block-one col-lg-4 col-md-6">
                        <a href="{{url('blog/'.$b->blog_slug)}}">
                            <div class="inner-box">
                                <div class="image">
                                        <img class="lazy-image owl-lazy"
                                            src="{{ url($b->attachment_url) }}"
                                            data-src="{{ url($b->attachment_url) }}"
                                            alt=""
                                            style="width: 100%;
                                            height: 300px;
                                            object-fit: cover;"
                                            >
                                </div>
                                <div class="lower-content mt-1">
                                    {{-- <div class="category">Business</div> --}}
                                    <ul class="post-meta">
                                        <li>
                                            <i class="far fa-calendar-alt"></i> {{date('jS M y',strtotime($b->created_at))}}
                                        </li>
                                        {{-- <li><a href="#"><i class="far fa-user"></i>By Admin</a></li> --}}
                                    </ul>
                                    <h3>
                                        {{$b->blog_title}}
                                    </h3>
                                    <div class="text" style="text-align:justify">
                                        <?php echo substr_replace(strip_tags($b->description), "...", 100)	?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <center>{{$blogs->links("pagination::bootstrap-4")}} </center>
        </div>
    </section>


    @endsection

    @push('scripts')
        <script>

        </script>
    @endpush
