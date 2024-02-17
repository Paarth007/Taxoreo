
@extends('Website.Layout.app')
@section('content')
    <!-- Page Banner Section -->
        <section class="page-banner" style="height:10px !important;padding:160px 0px 100px !important;">
            <h1>{{$menu->page_title}}</h1>
        </section>
    <!--End Banner Section -->

    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-4">
                    <aside class="sidebar">
                        <div class="sec-title">
                            <div class="sub-title">
                                Checkout the documents
                            </div>
                            <select class="form-control"
                                    name="company_type_id"
                                    id="company_type_id"
                                    onchange="show_document(this.value)"
                                    >
                                @foreach ($company_and_documents as $c)
                                    <option value="{{$c['id']}}">{{$c['name']}}</option>
                                @endforeach
                            </select>
                        </div>

                        @foreach ($company_and_documents as $c)
                            <div class="sidebar-widget-two categories-widget-two"
                                id="document_list_{{$c['id']}}"
                                >
                                <h3>{{$c['name']}}</h3>
                                <div class="widget-content">
                                    <ul>
                                        @if(count($c['documents']))
                                            @foreach ($c['documents'] as $d)
                                                <li>
                                                    <a href="services-details.html">
                                                        {{$d['document_name']}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                        <li>
                                            No Document Found !!!
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endforeach

                    </aside>
                </div>
                <div class="col-lg-8">
                    <div class="services-details">
                        <div class="content">
                            <div class="text" style="text-align: justify">
                                <?php
                                    echo $menu->main_content;
                                ?>
                            </div>
                            {{-- <blockquote>
                                <div class="text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                                <h4>Rosalina D. William</h4>
                            </blockquote> --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($menu->gst_at_glance || count($faqs) || count($reviews))
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-tab-box tabs-box" style="max-width:1600px">
                        <ul class="tab-btns tab-buttons clearfix">
                            @if($menu->gst_at_glance)
                                <li data-tab="#cat-1" class="tab-btn active-btn"><span>GST AT GLANCE</span></li>
                            @endif

                            @if(count($faqs))
                                <li data-tab="#cat-2" class="tab-btn "><span>FAQ</span></li>
                            @endif

                            @if(count($reviews))
                                <li data-tab="#cat-3" class="tab-btn"><span>REVIEWS</span></li>
                            @endif
                        </ul>


                        <div class="tabs-content">
                            @if($menu->gst_at_glance)
                                <div class="tab active-tab" id="cat-1">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">
                                            <p><?php echo html_entity_decode(htmlentities($menu->gst_at_glance)) ?></p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(count($faqs))
                                <div class="tab" id="cat-2">
                                    <div class="product-details-content">
                                        <div class="desc-content-box">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="accordion">
                                                        @foreach($faqs as $f)
                                                            <div class="card">
                                                                <div class="card-header" id="headingOne">
                                                                    <h5 class="mb-0">
                                                                        <button class="btn" data-toggle="collapse" data-target="#collapse{{$f->id}}" aria-expanded="true" aria-controls="collapseOne">
                                                                            {{$loop->iteration.") ".$f->question}}
                                                                        </button>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapse{{$f->id}}" class="collapse hide" aria-labelledby="headingOne" data-parent="#accordion">
                                                                    <div class="card-body">
                                                                        <?php echo strip_tags($f->answer); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            @if(count($reviews))
                                <div class="tab" id="cat-3">
                                    <div class="review-box-holder">
                                        <div class="review-area">
                                            @foreach($reviews as $r)
                                                <div class="column">
                                                    <div class="single-review-box">
                                                        <div class="image-holder">
                                                            <img src="{{asset('website/images/shop/review-1.png')}}" alt="Awesome Image">
                                                        </div>
                                                        <div class="text-holder">
                                                            <div class="top">
                                                                <div class="name">
                                                                    <h3>{{$r->name}} <span>– {{ date('M d, Y', strtotime($r->created_at)) }}</span></h3>
                                                                </div>
                                                            </div>
                                                            <div class="text">
                                                                <p><?php echo strip_tags($r->review) ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif












    @endsection

    @push('scripts')
        <script>
            $(document).ready(function(){
                show_document($('#company_type_id').val());
            })
           function show_document(id){
                $('.sidebar-widget-two').hide();
                $('#document_list_'+id).show();
           }
        </script>
    @endpush
