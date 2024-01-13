
@extends('Website.Layout.app')
@section('content')
    <section class="banner-section style-two">
		<div class="banner-carousel theme_carousel owl-theme owl-carousel"
             data-options='{"loop": true, "margin": 0, "autoheight":true, "lazyload":true, "nav": true, "dots": true, "autoplay": true, "autoplayTimeout": 6000, "smartSpeed": 300, "responsive":{ "0" :{ "items": "1" }, "768" :{ "items" : "1" } , "1000":{ "items" : "1" }}}'>
			<!-- Slide Item -->
			<div class="slide-item">
				<div class="image-layer lazy-image"
                     data-bg="{{ url('website/images/main-slider/2.jpg') }}">
                </div>

				<div class="auto-container">
					<div class="content-box">
                        <h3>Making Your Business Idea</h3>
						<h2>Prosper In This <br>Volatile Fund</h2>
						<div class="btn-box">
                            <a href="#" class="theme-btn btn-style-one">
                                <span class="btn-title">-- Our Services --</span>
                            </a>
                            <a href="#" class="theme-btn btn-style-two">
                                <span class="btn-title">-- Learn More --</span>
                            </a>
                        </div>
					</div>
				</div>
			</div>

			<!-- Slide Item -->
			<div class="slide-item">
				<div class="image-layer lazy-image"
                     data-bg="{{ url('website/images/main-slider/6.jpg') }}">
                </div>

				<div class="auto-container">
					<div class="content-box">
                        <h3>Making Your Business Idea</h3>
                        <h2>Prosper In This <br>Volatile Fund</h2>
                        <div class="btn-box"><a href="#" class="theme-btn btn-style-one"><span class="btn-title">-- Our Services --</span></a><a href="#" class="theme-btn btn-style-two"><span class="btn-title">-- Learn More --</span></a></div>
                    </div>
				</div>
			</div>
		</div>
    </section>

      <!-- Feature Section -->
      <section class="feature-section">
        <div class="auto-container">
            <div class="wrapper-box">
                <div class="row"
                    style=" display: flex;
                    justify-content: center;">
                    @foreach($categories as $c)
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 col-6">
                        <div class="feature-block-one">
                            <div class="inner-box">
                                <div class="icon"><span class="flaticon-team"></span></div>
                                <h5>{{$c}}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="services-section-three style-two">
        <div class="row">
            <div class="col-md-8">
                <div class="auto-container">
                    <div class="row">
                        @foreach($data as $id=>$value)
                        <div class="service-block-one col-lg-6">
                            <div class="inner-box p-3" style="margin-top:-20px !important">
                                <h3>{{$value['name']}}</h3>
                                <div class="container">
                                    @foreach($value['services'] as $v)
                                    <div class="row">
                                        <div class="col-md-8" style="text-align: left">
                                            <input class="checkbox form-check-input"
                                                type="checkbox"
                                                style="width: 1.3rem;height: 1.3rem"
                                                id="checkbox_{{$v['id']}}"
                                                onchange="userSelectService({{$v['id']}}, '{{$v['name']}}', {{$v['actual_amount']}})"
                                                >
                                            <label class="mt-1 form-check-label" style="padding-left: 10px" for="check_1">
                                                {{$v['name']}}
                                            </label>
                                        </div>
                                        <div class="col-md-2" style="text-align: left;display:flex">
                                            <p
                                            style="font-size:18px"
                                            > Rs.{{$v['actual_amount']}}</p>
                                            <s class="ml-1" style="font-size:12px">Rs.{{$v['display_amount']}}</s>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> <!--Service Block-->
                        @endforeach
                    </div><!--ROW-->
                </div><!--Auto Continer-->

            </div><!--COL-MD-8-->
            <div class="col-md-4" >
                <div class="service-block-one p-0" style="background:#282828">
                    <div class="inner-box p-3" style="margin-top:-20px !important">
                        <h3>Selected Services</h3>
                        <div class="cart_items" id="cart_items">

                        </div>
                        <ul class="cart-total-table">
                            <li class="clearfix">
                                <span class="col col-title">Total</span>
                                <span class="col col-title" id="total_amount">Rs. 0</span>
                            </li>

                            <li>
                            </li>
                        </ul>

                        <a href="{{ url('register')}}" class="theme-btn btn-style-one mt-2">
                            <span class="btn-title">Register</span>
                        </a>
                    </div>


                </div>
            </div>
        </div><!--ROW-->
    </section>

    @endsection

    @push('scripts')
        <script>
            $(document).ready(function(){
                getSelectedServices();
            })

            function getSelectedServices(){
                $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "GET",
                        url: "{{ url('serviceOperation/getSelectedServices') }}",
                        success: function (resp){
                            if(resp['status']==1){
                                renderCart(resp['data']);
                            }else{
                                alert(resp['message'])
                            }
                        }
                    });
            }

            function userSelectService(id,name,actual_amount){
                let checkbox = document.getElementById('checkbox_'+id);
                if (checkbox.checked)
                {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: "{{ url('serviceOperation/addService') }}",
                        data: {'service_id':id,'service_name':name,'actual_amount':actual_amount},
                        success: function (resp){
                            if(resp['status']==1){
                                renderCart(resp['data']);
                            }else{
                                alert(resp['message'])
                            }
                        }
                    });
                }else{
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: "{{ url('serviceOperation/removeService') }}",
                        data: {'service_id':id},
                        success: function (resp){
                            if(resp['status']==1){
                                renderCart(resp['data']);
                            }else{
                                alert(resp['message'])
                            }
                        }
                    });
                }
            }

            function renderCart(data)
            {
                if(data.length)
                {
                    var cart="";
                    var total=0;
                    $('#cart_items').html('');
                    data.forEach(function(obj) {
                        let checkbox = document.getElementById('checkbox_'+obj.id);
                        if (!checkbox.checked) {
                            document.getElementById('checkbox_'+obj.id).checked=true;
                        }
                        var temp='<div class="row" id="cart_item_row_'+obj.id+'" style="font-size:18px">'
                                +'<div class="col-md-9" style="text-align: left;">'
                                    +obj.name
                                    +'</div>'
                                    +'<div class="col-md-2" style="display:flex;justify-content:space-between;">'
                                        +'<p>Rs.</p> '
                                        +'<p>'+ obj.actual_amount +'</p>'
                                    +'</div>'
                                +'</div>';
                        cart+=temp;
                        total=total+parseInt(obj.actual_amount);
                    });
                    $('#cart_items').append(cart);
                    $('#total_amount').html("Rs. " + total);
                }
            }
        </script>
    @endpush
