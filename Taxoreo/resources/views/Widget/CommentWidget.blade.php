
<div class="card">
    <div class="card-header p-1 bg-primary">
        <h4 class="text-white pl-2 pt-1">Comments</h4>
    </div>
    <div class="card-body p-1">
        <form action="{{ url('shared\comments') }}" method="post">
            @csrf
            <textarea class="form-control form-control-sm"
                    id="comment"
                    name="comment"
                    placeholder="Post your comment !!!"
                    rows="3"
                ></textarea>
            <input type="hidden"
                    id="client_added_service_id"
                    name="client_added_service_id"
                    value="{{$id}}">
            <span class="d-flex justify-content-between">
                <small>
                    <input type="checkbox"
                        id="show_to_client"
                        name="show_to_client"
                        value="1">
                        Show to Client
                </small>
                <button class="btn btn-primary btn-sm mt-1"
                        type="submit">
                    Post
                </button>
            </span>
        </form>
        @if(count($comments))
            <small class="mt-1"><b></b></small>
            <div class="p-3" style="height:300px;  overflow-y: auto;">
                @foreach($comments as $c)
                    <div class="row border-bottom">
                        <div class="col">
                            <small class="d-flex justify-content-between">
                                <b>
                                    {{$c->username}}
                                    @if(Session::get('user_type')!="CLIENT" && $c->show_to_client==1)
                                            <span class="badge badge-primary"
                                            style="font-size:10px"
                                            >Shown To Client</span>
                                        @endif
                                </b>
                                {{date('d-m-Y',strtotime($c->created_at))}}
                            </small>
                            <p style="font-weight:400;font-size:14px;text-align:justify;padding:0px">
                                <form  id="delete_comment_{{$c->id}}" method="POST" action="{{ url('shared/comments/'.$c->id) }}">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                                <i class="fa fa-trash text-danger" aria-hidden="true"
                                    onclick="document.getElementById('delete_comment_{{$c->id}}').submit();"
                                ></i>
                                {{$c->comment}}
                            </p>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div> <!--CARD-->
