@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
    <link rel="stylesheet" href="{{ asset('/js/morris-chart/morris.css') }}">
@endsection
@section('content')
<!-- page start-->
<div class="row">
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-ticket"></i></span>
            <div class="mini-stat-info">
                <span>25</span>
                Total outlet
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><i class="fa fa-tag"></i></span>
            <div class="mini-stat-info">
                <span>47</span>
                Total users
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon green"><i class="fa fa-money"></i></span>
            <div class="mini-stat-info">
                <span>RM 12,500</span>
                Total Sale
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon green"><i class="fa fa-money"></i></span>
            <div class="mini-stat-info">
                <span>RM 3586</span>
                Total TopUp Amount
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-suitcase"></i></span>
            <div class="mini-stat-info">
                <span>76</span>
                Total Transaction
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-suitcase"></i></span>
            <div class="mini-stat-info">
                <span>13</span>
                Total Vouchers
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9">
        <!--earning graph start-->
        <section class="panel">
            <header class="panel-heading">
                Top Earning Graph <span class="tools pull-right">
            <a href="javascript:;" class="fa fa-chevron-down"></a>
            <a href="javascript:;" class="fa fa-cog"></a>
            <a href="javascript:;" class="fa fa-times"></a>
            </span>
            </header>
            <div class="panel-body">
                <div id="graph-area" class="main-chart">
                </div>
            </div>
        </section>
        <!--earning graph end-->
    </div>
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <div class="top-stats-panel">
                    <div class="daily-visit">
                        <h4 class="widget-h">Daily Sale</h4>
                        <div id="daily-visit-chart" style="width:100%; height: 100px; display: block">

                        </div>
                        <ul class="chart-meta clearfix">
                            <li class="pull-left visit-chart-value">RM 3233</li>
                            <li class="pull-right visit-chart-title"><i class="fa fa-arrow-up"></i> 15%</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- page end-->
@endsection
@section('scripts')

<script src="{{ asset('/js/gauge/gauge.js') }}"></script>
<!--Morris Chart-->
<script src="{{ asset('/js/morris-chart/morris.js') }}"></script>
<script src="{{ asset('/js/morris-chart/raphael-min.js') }}"></script>

<script src="{{ asset('/js/dashboard.js') }}"></script>
@endsection