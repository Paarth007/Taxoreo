<div class="card">
    <div class="card-header p-1 bg-primary">
        <h4 class="text-white pl-2 pt-1">Client Details</h4>
    </div>
    <div class="card-body p-1">
        @if(isset($client_detail->first_name))
            <div class="row m-0">
                <div class="col-md-4">
                    <label class="form-control-label">
                        Client Name :
                    </label>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <p class="text-bold" style="font-size:15px"><b>{{$client_detail->first_name." ".$client_detail->last_name}}</b></p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
