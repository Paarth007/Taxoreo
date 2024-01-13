@extends('Superadmin.Layout.Master')

@section('content-header')

<div class="header py-1">
    <div class="container-fluid">
        <div class="header-body ">
            <div class="row">
                <div class="col-lg-6 col-7 text-primary text-left">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item">
                                <a href="#"><i class="fas fa-home text-primary"></i> Website</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Blog</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ url($url.'/create') }}" class="btn btn-sm btn-primary">
                        <b>
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Add Blog
                        </b>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')

    {{-- <div class="card mt-1">
        <div class="card-body p-1">
            <div class="row">
                <div class="col-4">
                    <label class="form-control-label">Search Course Group :</label>
                    <input type="text" class="form-control form-control-sm" id="search_by_course_group_name" name="search_by_course_group_name">
                </div>
                <div class="col-4">
                    <label class="form-control-label">Search Course :</label>
                    <input type="text" class="form-control form-control-sm" id="search_by_course_name" name="search_by_course_name">
                </div>
                <div class="col-md-3 text-left">
                    <button type="button" id="search_result" class="btn btn-sm bg-primary text-white mt-4">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <button class="btn btn-sm bg-danger text-white mt-4" onclick="refresh_search_result()">
                        <i class="fas fa-sync-alt"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="card mt-0 mt--3">
        <div class="card-body pt-0 m-0">
            <div class="table-responsive py-1">
                <p class="form-control-label">Select Column To Hide:
                    <span class="badge badge-primary toggle-vis" data-column="0">Action</span>
                    <span class="badge badge-primary toggle-vis" data-column="1">Id</span>
                    <span class="badge badge-primary toggle-vis" data-column="2">Select All</span>
                    <span class="badge badge-primary toggle-vis" data-column="4">Blog Name</span>
                    <span class="badge badge-primary toggle-vis" data-column="6">Status</span>
                    <span class="badge badge-primary toggle-vis" data-column="7">Created At</span>
                </p>

                <table id="data-table" class="table table-hover table-flush mt-2" style="width:100%">
                    <thead class="thead-light">
                        <tr class="">
                            <th class="p-1 text-center" style="width:10px">Action</th>
                            <th class="p-1 text-center">Id</th>
                            <th class="p-1 text-center"><input name="select_all" id="select_all" type="checkbox"/></th>
                            <th class="p-1 text-center">Title</th>
                            <th class="p-1 text-center">Slug</th>
                            <th class="p-1 text-center">Attachment</th>
                            <th class="p-1 text-center">Status</th>
                            <th class="p-1 text-center">Created At</th>
                        </tr>
                    </thead>
                    <tfoot class="p-0">
                        <tr class="p-0">
                            <th class="p-1"></th>
                            <th class="p-1"></th>
                            <th class="p-1"></th>
                            <th class="p-1">Title</th>
                            <th class="p-1">Slug</th>
                            <th class="p-1"></th>
                            <th class="p-1"></th>
                            <th class="p-1"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var excludedColumns=[0,1,2,3,9,10];
    var table=null;
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
        });

    table=$('#data-table').DataTable({
            processing: true,
            serverSide: true,
            language: {paginate: {next: '&#8594;', previous: '&#8592;'}},
            pageLength:25,
            columnDefs:[
                    {
                        targets: 3,
                        className: 'text-left',
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).css('padding', '3px')
                        },
                    },
                    {
                        targets: '_all',
                        className: 'text-center',
                        createdCell: function (td, cellData, rowData, row, col) {
                            $(td).css('padding', '3px')
                        }
                    }
                ],
            dom: '<"container-fluid"<"row"<"col"l><"col"B><"col"f>>>rtip',
            buttons:[
                    { extend: 'print', className: 'btn btn-outline-info btn-sm p-1 py-0 px-0'},
                    { extend: 'copy', className: 'btn btn-outline-info btn-sm p-1 py-0 px-0'},
                    { extend: 'excel', className: 'btn btn-outline-warning btn-sm p-1 py-0 px-0' },
                    { extend: 'csv', className: 'btn btn-outline-success btn-sm p-1 py-0 px-0' },
                    { extend: 'pdf', className: 'btn btn-outline-default btn-sm p-1 py-0 px-0' },
                ],
            ajax:{
                    url:"<?php echo url($url.'/show'); ?>",
                        type: 'GET',
                        data: function (d){
                            d.course_name = $('#search_by_course_name').val();
                            d.course_group_name = $('#search_by_course_group_name').val();
                        }
                    },
            columns:[
                    {data: 'action', name: 'action'},
                    {data: 'DT_RowIndex'},
                    {data: 'select_checkbox', name: 'select_checkbox',orderable: false, searchable: false},
                    {data: 'blog_title',orderable: true, searchable: true},
                    {data: 'blog_slug',orderable: true, searchable: true},
                    {data: 'attachment_url',orderable: true, searchable: true},
                    {data: 'is_active',orderable: true, searchable: true},
                    {data: 'created_at',orderable: true, searchable: true},
                ],
            initComplete: function () {
                this.api().columns().every(function (d) {
                    if(!excludedColumns.includes(d)){
                        var column = this;
                        var title = column.footer().textContent;
                        // Create input element and add event listener
                        $('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />')
                            .appendTo($(column.footer()).empty())
                            .on('keyup change clear', function () {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                        });
                    }
                })
            },
        });
    });

    $('span.toggle-vis').on('click', function (e) {
        e.preventDefault();
        var column = table.column($(this).attr('data-column'));
        column.visible(!column.visible());
    });

    $('#search_result').click(function(){
        $('#data-table').DataTable().draw(true);
    });
</script>
@endpush
