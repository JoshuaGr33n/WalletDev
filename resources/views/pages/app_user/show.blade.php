@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
<link href="{{ asset('/js/advanced-datatable/css/demo_page.css') }}" rel="stylesheet" />
<link href="{{ asset('/js/advanced-datatable/css/demo_table.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('/js/data-tables/DT_bootstrap.css') }}" />
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
    <div class="col-md-12">
        <section class="panel">
            <div class="panel-body profile-information">
                <div>
                    <span class="tools pull-right" style="margin-bottom: 5px;">
                      <a href="{{ route('appuser.index') }}" title="Back" class="btn btn-primary btn-xs"><i class="fa fa-reply"></i></a>
                    </span>
                </div>
               <div class="col-md-3">
                   <div class="profile-pic text-center">
                        @if($userInfo->user_image)
                            <img src="{{ asset('uploads/app_users/'.$userInfo->user_image) }}" id="user_image">
                        @else
                            <img src="{{ asset('images/lock_thumb.jpg') }}" alt=""/>
                        @endif
                   </div>
               </div>
               <div class="col-md-6">
                   <div class="profile-desk">
                        <h1>{{ $userInfo->first_name }} {{ $userInfo->last_name }}</h1>
                       <div class="prf-box">
                            <h3 class="prf-border-head">Profile Info</h3>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">DOB</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->dob }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Email</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->email }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Phone Number</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->phone_number }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Member ID</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->member_id }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Registered Date</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->registered_date }}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-6 col-xs-6">Last Login</div>
                                <div class="col-md-6 col-xs-6">
                                    <strong>{{ $userInfo->last_login }}</strong>
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
                                    <span>RM {{(!empty($userInfo->user_wallet) ? $userInfo->user_wallet->wallet_balance : 0)}}</span>
                                    Total Amount
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mini-stat clearfix">
                                <span class="mini-stat-icon tar"><i class="fa fa-trophy"></i></span>
                                <div class="mini-stat-info">
                                    <span>{{(!empty($userInfo->user_reward) ? $userInfo->user_reward->reward_point : 0)}}</span>
                                    Reward Points
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               <div class="clearfix"></div>
               <div class="row">
                    <div class="col-md-3">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon orange"><i class="fa fa-shopping-cart"></i></span>
                            <div class="mini-stat-info">
                                <span>{{ $totalTransaction }}</span>
                                Total Transaction
                            </div>
                        </div>
                    </div>
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
                            <span class="mini-stat-icon green"><i class="fa fa-gift"></i></span>
                            <div class="mini-stat-info">
                                <span>7</span>
                                Total Voucher
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#overview">
                            All Transactions
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#top-up-list">
                            Top Up
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#pay-list" class="contact-map">
                            Paid
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
                    <div id="top-up-list" class="tab-pane ">
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
                                                        <th>TopUp By</th>
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
                    <div id="pay-list" class="tab-pane ">
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
                                                        <th>Paid By</th>
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
    </div>
</div>

@endsection
@section('scripts')
<script type="text/javascript" language="javascript" src="{{ asset('/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/data-tables/DT_bootstrap.js') }}"></script>

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
          url: "{{ route('getAllTransaction') }}",
          type: 'GET',
          data: function (d) {
            d.user_id = '{{$user_id}}';
          }
        },
        columns: [
            {data: 'transaction_type', name: 'transaction_type'},
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'transaction_date', name: 'transaction_date'},
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
          url: "{{ route('getAllTopup') }}",
          type: 'GET',
          data: function (d) {
            d.user_id = '{{$user_id}}';
          }
        },
        columns: [
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'transaction_datetime', name: 'transaction_datetime'},
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
          url: "{{ route('getAllPaid') }}",
          type: 'GET',
          data: function (d) {
            d.user_id = '{{$user_id}}';
          }
        },
        columns: [
            {data: 'amount', name: 'amount'},
            {data: 'transaction_id', name: 'transaction_id'},
            {data: 'outlet_id', name: 'outlet_id'},
            {data: 'action_by', name: 'action_by'},
            {data: 'transaction_datetime', name: 'transaction_datetime'},
        ],
        order: [[0, 'desc']],
        responsive:true,
        drawCallback: function( settings ) {
        }
    });
});
</script>
@endsection