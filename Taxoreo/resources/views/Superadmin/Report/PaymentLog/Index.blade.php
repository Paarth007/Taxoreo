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
                                <a href="#"><i class="fas fa-home text-primary"></i> Report</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Payment Logs</a></li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('content')
    <div class="card mt-0 mt--3">
        <div class="card-body pt-0 m-0">
            <div class="table-responsive py-1">
                <?php
                    $columns=[
                        'Action'=>"0",
                        'Id'=>"0",
                        'Select All'=>"0",
                        'Particular'=>"1",
                        'Easebuzz id'=>"1",
                        "Name"=>"1",
                        "Amount"=>"1",
                        'status'=>"1",
                        'Created At'=>"0"
                    ]
                ?>
                <p class="form-control-label">Select Column To Hide:
                    @foreach($columns as $key=>$value)
                        <span class="badge badge-primary toggle-vis" data-column="{{$loop->iteration-1}}">{{$key}}</span>
                    @endforeach
                </p>

                <table id="data-table" class="table table-hover table-flush mt-2" style="width:100%">
                    <thead class="thead-light">
                        <tr class="">
                            <?php
                                foreach($columns as $key=>$value){
                                    $style="";
                                    switch($key){
                                        case 'Action':
                                            $style="width:10px";
                                            $class="text-center";
                                            break;
                                        case 'Select All':
                                            $style="";
                                            $key='<input name="select_all" id="select_all" type="checkbox"/>';
                                            $class="text-center";
                                            break;
                                        default :
                                            $style="";
                                            $class="text-center";
                                            break;
                                    }
                                    echo '<th class="p-1 '.$class.'" '.$style.'>'.$key.'</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tfoot class="p-0">
                        <tr class="p-0">
                            @foreach($columns as $key=>$value)
                                <th class="p-1">{{$value==1 ? $key : "" }}</th>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    var excludedColumns=[0,1,2,5,6];
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
                    {data: 'payment_for',orderable: true, searchable: true},
                    {data: 'easepayid',orderable: true, searchable: true},
                    {data: 'firstname',orderable: true, searchable: true},
                    {data: 'amount',orderable: true, searchable: true},
                    {data: 'status',orderable: true, searchable: true},
                    {data: 'addedon',orderable: true, searchable: true},
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
