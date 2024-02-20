<div class="card">
    <div class="card-header p-1 bg-primary">
        <h4 class="text-white pl-2 pt-1">Document List</h4>
    </div>
    <div class="card-body p-1">
        <table class="table table-border border">
            <thead class="thead-light">
                <th>Sr</th>
                <th>Doc Name</th>
                <th>Action</th>
            </thead>
            <tbody>
                @if(count($documents))
                    @foreach($documents as $d)
                        <tr class="p-1">
                            <td class="p-1 text-center">{{$loop->iteration}}</td>
                            <td class="p-1">{{$d->document_name}}</td>
                            <td class="p-1">
                                @if($d->document_path)
                                    <a href="{{ url($d->document_path) }}"
                                        target="_blank"
                                        class="btn btn-primary btn-sm"
                                        >
                                        <i class="far fa-folder-open"></i>
                                    </a>
                                    <a href="{{ url($d->document_path) }}"
                                        download
                                        class="btn btn-danger btn-sm"
                                        tooltip="Download"
                                        >
                                        <i class="fas fa-download"></i>
                                    </a>
                                @else
                                    NOT UPLAODED
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
