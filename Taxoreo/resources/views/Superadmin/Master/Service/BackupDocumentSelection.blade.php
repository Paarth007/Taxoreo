<div class="row m-0">
    <div class="col-md-3 text-right">
        <label class="form-control-label">Required Documents :</label>
    </div>
    <div class="col-md-9 text-left">
        <div class="row m-0">
            <div class="col-md-2 text-right p-0 m-0">
            </div>
            <div class="col-md-3 text-right ">
                <input type="checkbox" id="" onclick="select_all('',this.checked)"> <b>Select All</b>
            </div>
        </div>
        @foreach($company_types as $c)
            <div class="row m-0">
                <div class="col-md-3 text-right">
                    <label class="form-control-label"> {{$c->company_type_name}}</label>
                </div>
                <div class="col-md-9 text-left">
                    <div class="row">
                        <div class="col-md-1">
                            <input type="checkbox" id="" onclick="select_all({{$c->id}},this.checked)">
                        </div>
                        <div class="col-md-11">
                            <i>Select all</i>
                        </div>
                        @foreach ($required_documents as $d)
                            <div class="col-md-1">
                                <input type="checkbox"
                                        class="document_class_ document_class_{{$c->id}}"
                                        id="document_{{$c->id}}_{{$d->id}}"
                                        name="required_documents[{{$c->id}}][]"
                                        {{ $service && in_array($d->id,$service_documents[$c->id]) ? 'checked' : "" }}
                                        value="{{$d->id}}"
                                    >
                            </div>
                            <div class="col-md-11">
                                {{$loop->iteration}}.{{$d->document_name}}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
</div>
