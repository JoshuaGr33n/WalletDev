@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
    <link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
    <link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('/js/data-tables/buttons.dataTables.min.css') }}" />
    <style type="text/css">
    .profile-desk .pf-status {
        padding: 5px 0px 10px 0px;
        margin: 0px 0px 0px 0px;
    }
    #topup-table{ width: -webkit-fill-available !important; }
    #paid-table{ width: -webkit-fill-available !important; }
    .profile-information .mini-stat { background: #e8fcfb; }
    .profile-information .profile-desk {
        margin-bottom: 10px;
    }
    </style>
@endsection
@section('content')
<!-- page start-->
<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            <div class="panel-body">
                <div class="position-center">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="outlet_id">Outlet</label>
                            <select id="outlet_id" name="outlet_id" class="form-control" size="1">
                                <option value="0" disabled="disabled" selected> -- Select Outlet -- </option>
                                @foreach($outletLists as $outlet)
                                    <option @if($outlet->id == $outlet_id) selected="selected" @endif value="{{$outlet->id}}">{{$outlet->outlet_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="type">Transaction Type</label>
                            <select id="type" name="type" class="form-control" size="1">
                                <option value="0" disabled="disabled" selected> -- Select type -- </option>
                                <option @if($type == 1) selected="selected" @endif value="1">Topup</option>
                                <option @if($type == 2) selected="selected" @endif value="2">Paid</option>
                                <option @if($type == 3) selected="selected" @endif value="3">All</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Filter</button>
                    </form>
                </div>
            </div>
        </section>
        
        @if($outlet_id)
        <section class="panel">
            <div class="panel-body profile-information">
               <div class="col-md-3">
                   <div class="profile-pic text-center">
                        @if($outletInfo->outlet_logo)
                            <img src="{{ asset('uploads/outlets/'.$outletInfo->outlet_logo) }}" id="outlet_logo">
                        @else
                            <img src="{{ asset('images/lock_thumb.jpg') }}" alt=""/>
                        @endif
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="profile-desk">
                        <h1>{{(!empty($outletInfo->merchant) ? $outletInfo->merchant->company_name : '')}}</h1>
                        <h2>{{ $outletInfo->outlet_name }}</h2>
                        <h4>{{ $outletInfo->outlet_address }}</h4>
                       <div class="prf-box">
                            <h3 class="prf-border-head">Outlet Info</h3>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Phone</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $outletInfo->outlet_phone }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Email</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $outletInfo->outlet_email }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Hours</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $outletInfo->outlet_hours }}</strong>
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon orange"><i class="fa fa-money"></i></span>
                                <div class="mini-stat-info">
                                    <span>RM {{$mrcntPendingAmt}}</span>
                                    Pending Amount
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                <div class="mini-stat-info">
                                <span>{{ $totalTransaction }}</span>
                                Total Transaction
                            </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon tar"><i class="fa fa-money"></i></span>
                                <div class="mini-stat-info">
                                <span>{{ $totalTransactionAmt }}</span>
                                Total Transaction Amount
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="clearfix"></div>
               <div class="row">
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon tar"><i class="fa fa-tag"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $totalTopup }}</span>
                                Total Topup
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $totalPaid }}</span>
                                Total Paid
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon tar"><i class="fa fa-tag"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $totalTopupAmt }}</span>
                                Total Amount Topup
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $totalPaidAmt }}</span>
                                Total Amount Paid
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    @if($type==3)
                    <li @if($type == 3) class="active" @endif>
                        <a data-toggle="tab" href="#overview">
                            All Transaction
                        </a>
                    </li>
                    @endif
                    @if($type==1 || $type==3)
                    <li @if($type == 1) class="active" @endif>
                        <a data-toggle="tab" href="#top-up-list">
                            Top Up
                        </a>
                    </li>
                    @endif
                    @if($type==2 || $type==3)
                    <li @if($type == 2) class="active" @endif>
                        <a data-toggle="tab" href="#pay-list" class="contact-map">
                            Paid
                        </a>
                    </li>
                    @endif
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content tasi-tab">
                    <div id="overview" class="tab-pane @if($type == 3) active @endif">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <div class="adv-table">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="alltrans-table">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Amount (RM)</th>
                                                        <th>Transaction id</th>
                                                        <th>Outlet Name</th>
                                                        <th>Topup/Pay By</th>
                                                        <th>Transaction date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div id="top-up-list" class="tab-pane @if($type == 1) active @endif">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <div class="adv-table">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="topup-table">
                                                <thead>
                                                    <tr>
                                                        <th>Amount (RM)</th>
                                                        <th>Transaction id</th>
                                                        <th>Outlet Name</th>
                                                        <th>Topup/Pay By</th>
                                                        <th>Transaction date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div id="pay-list" class="tab-pane @if($type == 2) active @endif">
                        <div class="row">
                            <div class="col-md-12">
                                <section class="panel">
                                    <div class="panel-body">
                                        <div class="adv-table">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="paid-table" style="width: -webkit-fill-available;">
                                                <thead>
                                                    <tr>
                                                        <th>Amount (RM)</th>
                                                        <th>Transaction id</th>
                                                        <th>Outlet Name</th>
                                                        <th>Topup/Pay By</th>
                                                        <th>Transaction date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif
    </div>
</div>
<!-- page end-->
@endsection
@section('scripts')
<!--Core js-->
<!--<script src="{{ asset('/js/flot-chart/jquery.flot.tooltip.min.js') }}"></script>-->
<!--dynamic table-->
<script type="text/javascript" language="javascript" src="{{ asset('/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/DT_bootstrap.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/buttons.flash.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/buttons.print.min.js') }}"></script>
<!--common script init for all pages-->
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table1 = $('#alltrans-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('getOutletTransaction') }}",
          type: 'GET',
          data: function (d) {
            d.outlet_id = '{{$outlet_id}}';
          }
        },
        columns: [
            {data: 'type', name: 'type'},
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'tranasaction_datetime', name: 'tranasaction_datetime'},
        ],
        select: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-primary btn-sm excel_btn',
                title: 'Wallet - Outlet Reports',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        }
    });
    var table2 = $('#topup-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('getOutletTopup') }}",
          type: 'GET',
          data: function (d) {
            d.outlet_id = '{{$outlet_id}}';
          }
        },
        columns: [
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'tranasaction_datetime', name: 'tranasaction_datetime'},
        ],
        select: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-primary btn-sm excel_btn',
                title: 'Wallet - Outlet Top-up Reports',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        }
    });
    var table3 = $('#paid-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('getOutletPaid') }}",
          type: 'GET',
          data: function (d) {
            d.outlet_id = '{{$outlet_id}}';
          }
        },
        columns: [
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'tranasaction_datetime', name: 'tranasaction_datetime'},
        ],
        select: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'collection',
                text: 'Export',
                className: 'btn btn-primary btn-sm excel_btn',
                title: 'Wallet - Outlet Paid Reports',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        }
    });
});
</script>
@endsection