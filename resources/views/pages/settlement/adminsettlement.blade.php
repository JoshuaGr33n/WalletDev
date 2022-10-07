@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
    <link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
    <link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('/js/data-tables/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/bootstrap-daterangepicker/daterangepicker-bs3.css') }}" />
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
                    <form class="form-inline" name="filterForm" id="filterForm" autocomplete="off" role="form">
                        
                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: -webkit-right;">
                            <div class="form-group">
                                <label class="sr-only" for="outlet_id">Select Outlet</label>
                                <select id="outlet_id" name="outlet_id" class="form-control" size="1" style="height: 34px;">
                                    <option value="0" disabled="disabled" selected> -- Select Outlet -- </option>
                                    @foreach($outletLists as $outlet)
                                        <option @if($outlet->id == $outlet_id) selected="selected" @endif value="{{$outlet->id}}">{{$outlet->outlet_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @php
                            $filter_type = '';
                            $allActiveClass    = 'btn-default';
                            $monthActiveClass  = 'btn-default';
                            $weekActiveClass   = 'btn-default';
                            $customActiveClass = 'btn-default';
                            
                            @endphp
                            <!-- <button type="button" id="allFilter" value="all" class="btn {{ $allActiveClass }} filterBtn">All</button>
                            <button type="button" id="todayFilter" value="today" class="btn {{ $weekActiveClass }} filterBtn">Today</button>
                            <button type="button" id="weekFilter" value="week" class="btn {{ $weekActiveClass }} filterBtn">Week</button>
                            <button type="button" id="monthDatePicker" value="month" class="btn {{ $monthActiveClass }} filterBtn">Month</button>
                            <button type="button" id="customFilter" class="btn {{ $customActiveClass }}">Custom</button>-->
                            <input type="hidden" name="filter_type" id="filter_type" value="{{ $filter_type }}">
                            <input type="text" name="daterange" id="daterange" class="form-control" value="{{ $daterange }}" placeholder="" />
                            <button type="submit" onClick="return outletFilter();" class="btn btn-success">Filter</button>
                        </div>
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
                        @if($settleToHead)
                            <div class="col-md-12">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info">
                                        <span>{{ $settleToHead }}</span>
                                        Settlement to Head 
                                    </div>
                                    <button type="submit" onclick="return checkUserPassword(1, '{{ $settleToHead }}');" class="btn btn-sm btn-success">Settlement</button>
                                </div>
                            </div>
                        @endif
                        @if($settleToOutlet)
                            <div class="col-md-12">
                                <div class="mini-stat clearfix">
                                    <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                    <div class="mini-stat-info">
                                        <span>{{ $settleToOutlet }}</span>
                                        Settlement to Outlet
                                    </div>
                                    <button type="submit" onclick="return checkUserPassword(2, '{{ $settleToOutlet }}');" class="btn btn-sm btn-success">Settlement</button>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                                <div class="mini-stat-info">
                                <span>{{ $totalTransaction }}</span>
                                Total Transaction
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
            <div class="clearfix"></div>
            <div class="row">
            
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#overview">
                            All Transaction
                        </a>
                    </li>
                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content tasi-tab">
                    <div id="overview" class="tab-pane active">
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
<script type="text/javascript" src="{{ asset('/js/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/daterangepicker/daterangepicker.js') }}"></script>
<!--common script init for all pages-->
<script type="text/javascript">
$(function() {
    $('input[name="daterange"]').daterangepicker({
        timePicker: false,
        timePickerIncrement: 30,
        locale: {
            format: 'dd/mm/yyyy'
        },
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
});
function outletFilter(){
    var outlet_id = $('#outlet_id').val();
    var daterange = $('#daterange').val();
    if(outlet_id == '' || outlet_id == null){ alert('Please select outlet.'); return false; }
    //if(daterange == '' || daterange == null){ alert('Please select date filter.'); return false; }
    return true;
}

function checkUserPassword(settlement_type, amount){
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html('');
    $( '#modal_title' ).html( 'Verify Password' );
    if(settlement_type) {
        $.ajax({
            url: "{{ route('getVerifyPasswordForm') }}",
            data: { "settlement_type": settlement_type, "amount": amount },
            type: "post",
            dataType: "html",
            success: function (html) {
               $( '#modal_body' ).html(html);
            }
        });
    }
}
function verifyPassword(){
    var password = $('#verifypassword_form #password').val();
    var settlement_type = $('#verifypassword_form #settlement_type').val();
    var amount = $('#verifypassword_form #amount').val();
    if(password && settlement_type) {
        $.ajax({
            url: "{{ route('verifyPassword') }}",
            data: {"password": password },
            type: "post",
            dataType: "json",
            success: function (res) {
                if(res.status == 'failed'){
                    if(res.error.password){
                        alert(res.error.password);
                    }else if(res.error.msg){
                        alert(res.error.msg);
                    }else{
                        alert('Some problem found. Please try again.');
                    }
                }else{
                    alert(res.message);
                    checkUserPassword(settlement_type, amount)
                    //window.location.reload();
                }

            }
        });
    }
}

$(document).ready(function(){
    $(".daterangepicker .ranges li").click(function() {
        if($(this).html() == 'Today'){
            $('#filter_type').val(1);
        }else if($(this).html() == 'Yesterday'){
            $('#filter_type').val(2);
        }else if($(this).html() == 'Last 7 Days'){
            $('#filter_type').val(3);
        }else if($(this).html() == 'Last 30 Days'){
            $('#filter_type').val(4);
        }else if($(this).html() == 'This Month'){
            $('#filter_type').val(5);
        }else if($(this).html() == 'Last Month'){
            $('#filter_type').val(6);
        }else if($(this).html() == 'Custom Range'){
            $('#filter_type').val(7);
        }
    });

    // $(".filterBtn").click(function(){
    //     var value = $(this).val();
    //     var outlet_id = $('#outlet_id').val();
    //     var today = $('#today').val();
    //     if(outlet_id == '' || outlet_id == null){ alert('Please select outlet.'); return false; }
    //     if(value=='all'){
    //         window.location.href = "{{ route('adminSettlement.index') }}?outlet_id="+outlet_id+"&";
    //     }else if(value=='today'){
    //         window.location.href = "{{ route('adminSettlement.index') }}?outlet_id="+outlet_id+"&filter="+value+"&date="+today+""; 
    //     }else{
    //       window.location.href = "{{ route('adminSettlement.index') }}?outlet_id="+outlet_id+"&filter="+value+""; 
    //     }
    // });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table1 = $('#alltrans-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('getSettlementTransaction') }}",
          type: 'GET',
          data: function (d) {
            d.outlet_id = '{{$outlet_id}}';
            d.daterange = "{{$daterange}}";
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
});
</script>
@endsection