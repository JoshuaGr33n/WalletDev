@extends('layouts.layout_admin')
@section('style')

@endsection
@section('content')
<!-- page start-->
<div class="row">
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                Reward points
                <a onClick="return updatePointForm();" class="btn btn-info btn-xs" href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> Edit</a>
            </header>
            <div class="panel-body">
                <div class="row m-bot20">
                    <div class="col-md-6 col-xs-6">
                        <i class="fa fa-money"></i> 1 RM paid
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <span id="trpoint" class="btn btn-success btn-xs">{{ $rpoint }} Points</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                User maximum wallet balance
                <a onClick="return updateMaxWalletAmtForm();" class="btn btn-info btn-xs" href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> Edit</a>
            </header>
            <div class="panel-body">
                <div class="row m-bot20">
                    <div class="col-md-6 col-xs-6">
                        <i class="fa fa-money"></i> Maximum wallet balance
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <span id="tmaxwalletamt" class="btn btn-success btn-xs">{{ $maxwalletamt }}</span>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                Minimum/Maximum top-up amount
                <a onClick="return topupAmtForm();" class="btn btn-info btn-xs" href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> Edit</a>
            </header>
            <div class="panel-body">
                <div class="row m-bot20">
                    <div class="col-md-4 col-xs-4">
                        <p><i class="fa fa-money"></i> Min top-up amount</p>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <p><span id="tmintopupamt" class="btn btn-success btn-xs">{{ $mintopupamt }}</span></p>
                    </div>
                    <div class="col-md-4 col-xs-4">
                        <p><i class="fa fa-money"></i> Max top-up amount</p>
                    </div>
                    <div class="col-md-2 col-xs-2">
                        <p><span id="tmaxtopupamt" class="btn btn-success btn-xs">{{ $maxtopupamt }}</span></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-6">
        <section class="panel">
            <header class="panel-heading">
                Top-up amount Options
                <a onClick="return topupAmtOptionForm();" class="btn btn-info btn-xs" href="javascript:;" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="fa fa-edit"></i> Edit</a>
            </header>
            <div class="panel-body">
                <div class="row m-bot20">
                    <div class="col-md-6 col-xs-6">
                        <p>Amount options</p>
                    </div>
                    <div class="col-md-6 col-xs-6">
                        <p id="ttopupamtopn">
                            @if ($topupamtopn != "")
                              @foreach(explode(',', $topupamtopn) as $option) 
                                <span class="btn btn-success btn-xs">{{$option}}</span>
                              @endforeach
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <input type="hidden" name="rpoint" id="rpoint" value="{{$rpoint}}">
    <input type="hidden" name="mintopupamt" id="mintopupamt" value="{{$mintopupamt}}">
    <input type="hidden" name="maxtopupamt" id="maxtopupamt" value="{{$maxtopupamt}}">
    <input type="hidden" name="maxwalletamt" id="maxwalletamt" value="{{$maxwalletamt}}">
    <input type="hidden" name="topupamtopn" id="topupamtopn" value="{{$topupamtopn}}">
    <input type="hidden" name="enablePay" id="enablePay" value="{{$enablePay}}">
</div>

<!-- page end-->
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
function updatePointForm(){
    var value = $('#rpoint').val();
    var enablePay = $('#enablePay').val();
    if(enablePay==1){ var checked = 'checked'; }else{ var checked = ''; }
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html('');
    $( '#modal_title' ).html( 'Update Reward Points' );
    $( '#modal_body' ).html( '<form class="form-horizontal" id="updatePointForm" role="form">'+
                            '<div class="form-group">'+
                                '<label for="point" class="col-lg-4 col-sm-4 control-label">Point</label>'+
                                '<div class="col-lg-8">'+
                                    '<input type="text" class="form-control" name="point" id="point" placeholder="Point" value="'+value+'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="col-lg-offset-4 col-lg-8">'+
                                    '<input type="checkbox" '+checked+' name="pay" id="pay" placeholder="Point" value="1">'+
                                    '<label for="pay" class="control-label">&nbsp;Enable payment method</label>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="col-lg-offset-4 col-lg-8">'+
                                    '<button onClick="return updatePoints();" type="button" class="btn btn-success" id="updatePointBtn">Update</button>'+
                                    '<input type="hidden" id="_token" name="_token" value="{{ Session::token() }}" >'+
                                '</div>'+
                            '</div>'+
                        '</form>' );
}

function updatePoints() {
    var point = $('#updatePointForm #point').val();
    var token = $('#updatePointForm #_token').val();
    var enablePay = $("input[name=pay]:checkbox:checked").val();
    if(enablePay){ enablePay = 1; }else{ enablePay = 0; }
    $.ajax({
        url: "{{ route('updatepoints') }}",
        data: { "point": point, "enablePay": enablePay, "_token": token },
        type: "post",
        beforeSend: function() { 
            $("#updatePointBtn").prop('disabled', true);
        },
        success: function (data) {
            $("#updatePointBtn").prop('disabled', false);
            if(data.status=='success'){
                $.gritter.add({
                    title: 'Success',
                    text: data.message
                });
                $('#trpoint').html(point+' Points');
                $('#rpoint').val(point);
                $('#enablePay').val(enablePay);
                $('#myModal').modal('hide');
            }else{
                $.gritter.add({
                    title: 'Error',
                    text: data.message
                });
            }
        }
    });
}
function topupAmtForm(){
    var min_amount = $('#mintopupamt').val();
    var max_amount = $('#maxtopupamt').val();
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html( '' );
    $( '#modal_title' ).html( 'Minimum top-up amount' );
    $( '#modal_body' ).html( '<form class="form-horizontal" id="topupAmtForm" role="form">'+
                            '<div class="form-group">'+
                                '<label for="min_amount" class="col-lg-4 col-sm-4 control-label">Min Amount</label>'+
                                '<div class="col-lg-8">'+
                                    '<input type="text" class="form-control" name="min_amount" id="min_amount" placeholder="Minimum Amount" value="'+min_amount+'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<label for="max_amount" class="col-lg-4 col-sm-4 control-label">Max Amount</label>'+
                                '<div class="col-lg-8">'+
                                    '<input type="text" class="form-control" name="max_amount" id="max_amount" placeholder="Maximum Amount" value="'+max_amount+'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="col-lg-offset-4 col-lg-8">'+
                                    '<button onClick="return updateTopupAmt();" type="button" class="btn btn-success" id="updateTopupAmtBtn">Update</button>'+
                                    '<input type="hidden" id="_token" name="_token" value="{{ Session::token() }}" >'+
                                '</div>'+
                            '</div>'+
                        '</form>' );
}
function updateTopupAmt() {
    var min_amount = $('#topupAmtForm #min_amount').val();
    var max_amount = $('#topupAmtForm #max_amount').val();
    var token = $('#topupAmtForm #_token').val();
    $.ajax({
        url: "{{ route('updatetopupamt') }}",
        data: { "min_amount": min_amount, "max_amount": max_amount, "_token": token },
        type: "post",
        beforeSend: function() { 
            $("#updateTopupAmtBtn").prop('disabled', true);
        },
        success: function (data) {
            $("#updateTopupAmtBtn").prop('disabled', false);
            if(data.status=='success'){
                $.gritter.add({
                    title: 'Success',
                    text: data.message
                });
                $('#tmintopupamt').html(min_amount);
                $('#tmaxtopupamt').html(max_amount);
                $('#mintopupamt').val(min_amount);
                $('#maxtopupamt').val(max_amount);
                $('#myModal').modal('hide');
            }else{
                $.gritter.add({
                    title: 'Error',
                    text: data.message
                });
            }
        }
    });
}
function updateMaxWalletAmtForm(){
    var value = $('#maxwalletamt').val();
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html( '' );
    $( '#modal_title' ).html( 'Update Maximum wallet balance' );
    $( '#modal_body' ).html( '<form class="form-horizontal" id="updateMaxWalletAmtForm" role="form">'+
                            '<div class="form-group">'+
                                '<label for="amount" class="col-lg-4 col-sm-4 control-label">Amount</label>'+
                                '<div class="col-lg-8">'+
                                    '<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount" value="'+value+'">'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="col-lg-offset-4 col-lg-8">'+
                                    '<button onClick="return updateMaxWalletAmt();" type="button" class="btn btn-success" id="updateMaxWalletAmtBtn">Update</button>'+
                                    '<input type="hidden" id="_token" name="_token" value="{{ Session::token() }}" >'+
                                '</div>'+
                            '</div>'+
                        '</form>' );
}

function updateMaxWalletAmt() {
    var amount = $('#updateMaxWalletAmtForm #amount').val();
    var token = $('#updateMaxWalletAmtForm #_token').val();
    $.ajax({
        url: "{{ route('updatemaxwalletamt') }}",
        data: { "amount": amount, "_token": token },
        type: "post",
        beforeSend: function() { 
            $("#updateMaxWalletAmtBtn").prop('disabled', true);
        },
        success: function (data) {
            $("#updateMaxWalletAmtBtn").prop('disabled', false);
            if(data.status=='success'){
                $.gritter.add({
                    title: 'Success',
                    text: data.message
                });
                $('#tmaxwalletamt').html(amount);
                $('#maxwalletamt').val(amount);
                $('#myModal').modal('hide');
            }else{
                $.gritter.add({
                    title: 'Error',
                    text: data.message
                });
            }
        }
    });
}
function topupAmtOptionForm(){
    var amount_option = $('#topupamtopn').val();
    $( '#myModal' ).modal();
    $( '#modal_footer' ).html( '' );
    $( '#modal_title' ).html( 'Minimum top-up amount' );
    $( '#modal_body' ).html( '<form class="form-horizontal" id="topupAmtOptionForm" role="form">'+
                            '<div class="form-group">'+
                                '<label for="amount_option" class="col-lg-4 col-sm-4 control-label">Amount Options</label>'+
                                '<div class="col-lg-8">'+
                                    '<input type="text" class="form-control" name="amount_option" id="amount_option" placeholder="Amount Options" value="'+amount_option+'">'+
                                    '<p>enter options, comma separated ex: 10,20,30</p>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group">'+
                                '<div class="col-lg-offset-4 col-lg-8">'+
                                    '<button onClick="return updateTopupAmtOpn();" type="button" class="btn btn-success" id="updateTopupAmtOpnBtn">Update</button>'+
                                    '<input type="hidden" id="_token" name="_token" value="{{ Session::token() }}" >'+
                                '</div>'+
                            '</div>'+
                        '</form>' );
}
function updateTopupAmtOpn() {
    var amount_option = $('#topupAmtOptionForm #amount_option').val();
    var token = $('#topupAmtOptionForm #_token').val();
    $.ajax({
        url: "{{ route('updatetopupamtopn') }}",
        data: { "amount_option": amount_option, "_token": token },
        type: "post",
        beforeSend: function() { 
            $("#updateTopupAmtBtn").prop('disabled', true);
        },
        success: function (data) {
            $("#updateTopupAmtBtn").prop('disabled', false);
            if(data.status=='success'){
                $.gritter.add({
                    title: 'Success',
                    text: data.message
                });
                var options = new Array();
                var strarray = amount_option.split(',');
                for (var i = 0; i < strarray.length; i++) {
                    if(strarray[i]){
                        options.push('<span class="btn btn-success btn-xs">'+ strarray[i] +'</span>&nbsp;');
                    }
                }
                $('#ttopupamtopn').html(options);
                $('#topupamtopn').val(amount_option);
                $('#myModal').modal('hide');
            }else{
                $.gritter.add({
                    title: 'Error',
                    text: data.message
                });
            }
        }
    });
}
</script>
@endsection