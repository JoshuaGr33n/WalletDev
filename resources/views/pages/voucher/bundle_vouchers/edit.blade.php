@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
<link rel="stylesheet" href="{{ asset('/js/bootstrap-datepicker/css/datepicker.css') }}" />
<link href="{{ asset('/js/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/js/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" />

<!-- multiselect -->
<!-- <link rel="stylesheet" href="{{ asset('/multiselect/fonts/icomoon/style.css') }}"> -->

<link rel="stylesheet" href="{{ asset('/multiselect/css/jquery.multiselect.css') }}">

<!-- Bootstrap CSS -->
<!-- <link rel="stylesheet" href="{{ asset('/multiselect/css/bootstrap.min.css') }}"> -->

<!-- Style -->
<link rel="stylesheet" href="{{ asset('/multiselect/css/style.css') }}">
<!-- multiselect -->

<style type="text/css">
    .select2-container {
        width: 100%;
    }
</style>
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
    @endif
    <section class="panel">
        <header class="panel-heading">
            Create Bundle Voucher
            <span class="tools pull-right">
                <a href="{{ route('bundle-vouchers.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="box box-primary">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('bundle-vouchers.update',['bundle_voucher' => $voucherInfo->id ]) }}">
                    @csrf
                    {{method_field('PUT')}}
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group @error('bundle_voucher_name') has-error @enderror">
                                    <label for="bundle_voucher_name" class="col-sm-4 control-label">Bundle Voucher Name<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bundle_voucher_name" id="bundle_voucher_name" value="{{ $voucherInfo->bundle_voucher_name }}" placeholder="Bundle Voucher Name">
                                        @if($errors->has('bundle_voucher_name'))
                                        <p class="help-block">{{ $errors->first('bundle_voucher_name') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group @error('outlet_ids') has-error @enderror">
                                    <label for="outlet_ids" class="col-sm-4 control-label">Outlet<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="outlet_ids[]" id="outlet_ids" class="select2-multiple" tabindex="-1" multiple style="min-width: 315px;">
                                            <option @if($voucherInfo->outlet_ids=='all') selected @endif value="all">All</option>
                                            @php
                                            $outletArr = explode(',', $voucherInfo->outlet_ids);
                                            @endphp
                                            @foreach($outlet_lists as $outlet)
                                            <option value="{{$outlet->id}}" @if(in_array($outlet->id, $outletArr)) selected="selected" @endif>{{$outlet->outlet_name}}</option>
                                            @endforeach
                                        </select>

                                        @error('outlet_ids')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- multiselect -->
                                <div class="form-group @error('vouchers') has-error @enderror">
                                    <label for="free_items" class="col-sm-4 control-label">Select Vouchers<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="vouchers[]" multiple="multiple" class="3col active form-control">
                                            @php
                                            $vouchers = explode(',', $voucherInfo->vouchers);
                                            @endphp
                                            @foreach($voucherLists as $voucher)
                                            @if($voucher->free_voucher_type == "birthday")
                                            <option value="{{$voucher->id}}" @if(in_array($voucher->id, $vouchers)) selected="selected" @endif>{{$voucher->voucher_name}}(B)</option>
                                            @elseif($voucher->free_voucher_type == "welcome")
                                            <option value="{{$voucher->id}}" @if(in_array($voucher->id, $vouchers)) selected="selected" @endif>{{$voucher->voucher_name}}(W)</option>
                                            @else
                                            <option value="{{$voucher->id}}" @if(in_array($voucher->id, $vouchers)) selected="selected" @endif>{{$voucher->voucher_name}}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                        @error('vouchers')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- multiselect -->

                                <div class="form-group @error('sale_start_date') has-error @enderror">
                                    <label for="sale_start_date" class="col-sm-4 control-label">Sale Start Date<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="sale_start_date" id="sale_start_date" value="{{ date('Y-m-d',strtotime($voucherInfo->sale_start_date)) }}" placeholder="Sale Start Date">
                                        @error('sale_start_date')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group @error('sale_end_date') has-error @enderror">
                                    <label for="sale_end_date" class="col-sm-4 control-label">Sale End Date<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="sale_end_date" id="sale_end_date" value="{{ date('Y-m-d',strtotime($voucherInfo->sale_end_date)) }}" placeholder="Sale End Date">
                                        @error('sale_end_date')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                        @if ($message = Session::get('date_error'))
                                        <p class="help-block text-danger">{{ $message }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tAndC" class="col-sm-4 control-label">T&C</label>
                                    <div class="col-sm-8">
                                        <textarea class="wysihtml5 form-control" name="tAndC" id="tAndC" rows="5">{{ $voucherInfo->tAndC }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bundle_voucher_image" class="col-sm-4 control-label">Voucher Logo</label>
                                    <div class="col-sm-8">
                                        <input type='file' id="bundle_voucher_image" name="bundle_voucher_image" class="form-control" accept="image/*" />
                                        @if($voucherInfo->voucher_image)
                                        <img src="{{ asset('uploads/bundle_vouchers/'.$voucherInfo->bundle_voucher_image) }}" style="height:120px;width: auto;">
                                        @endif
                                        <input type='hidden' id="current_bundle_voucher_image" name="current_bundle_voucher_image" value="{{ $voucherInfo->bundle_voucher_image }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group @error('buy_bundle_voucher_with_wallet_credits_value') has-error @enderror">
                                    <label for="buy_bundle_voucher_with_wallet_credits_value" class="col-sm-4 control-label">Total Required Wallet Credits <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="buy_bundle_voucher_with_wallet_credits_value" id="buy_bundle_voucher_with_wallet_credits_value" class="form-control number" value="{{$wallet_credit_value}}" placeholder="Total Required Wallet Credit">
                                    </div>
                                </div>

                                <div class="form-group @error('max_qty') has-error @enderror">
                                    <label for="max_qty" class="col-sm-4 control-label">Max Qty <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="max_qty" id="max_qty" class="form-control number" value="{{ $voucherInfo->max_qty }}" placeholder="Max Qty">
                                        @error('max_qty')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group @error('single_user_qty') has-error @enderror">
                                    <label for="single_user_qty" class="col-sm-4 control-label">Single User Qty <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" name="single_user_qty" id="single_user_qty" class="form-control number" value="{{ $voucherInfo->single_user_qty }}" placeholder="Single User Qty">
                                        @error('single_user_qty')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group @error('bundle_voucher_description') has-error @enderror">
                                    <label for="bundle_voucher_description" class="col-sm-4 control-label">Description<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="wysihtml5 form-control" name="bundle_voucher_description" id="bundle_voucher_description" rows="5">{{ $voucherInfo->description }}</textarea>
                                        @error('bundle_voucher_description')
                                        <p class="help-block">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group" id="free_points">
                                    <label for="free_points_value" class="col-sm-4 control-label">Free Points </label>
                                    <div class="col-sm-8">
                                        <input type="text" name="free_points_value" id="free_points_value" class="form-control number" value="{{$free_points}}" placeholder="Free Points">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="free_items" class="col-sm-4 control-label">Free Items</label>
                                    <div class="col-sm-8">
                                        <select name="free_items_value[]" id="free_items_value" class="select2-multiple" tabindex="-1" multiple style="min-width: 315px;">
                                            <option @if($free_items=='all' ) selected @endif value="all">All</option>
                                            @php
                                            $free_items_list = explode(',', $free_items);
                                            @endphp
                                            @foreach($item_lists as $item)
                                            <option value="{{$item->id}}" @if(in_array($item->id, $free_items_list)) selected="selected" @endif>{{$item->item_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                                    <div class="col-lg-8">
                                        @if($voucherInfo->status == 3)
                                        <input type='text' disabled value="Expired" class="form-control" />
                                        <input type='hidden' name="status" value="{{$voucherInfo->status}}" />
                                        @else
                                        {!! Form::select('status', $status, $voucherInfo->status, ['class' => 'form-control']) !!}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <div class="col-md-offset-2 col-md-10">
                                <input type="hidden" value="" id="voucher_id" name="voucher_id">
                                <button type="submit" class="btn btn-success submit">Create</button>
                                <a href="{{ route('bundle-vouchers.index') }}" class="btn btn-warning">Cancel</a>
                            </div>
                        </div>

                </form>
            </div>
        </div>
    </section>
</div><!-- page end-->
@endsection
@section('scripts')

<!-- multiselect -->
<!-- <script src="{{ asset('/multiselect/js/jquery-3.3.1.min.js') }}"></script> -->
<script src="{{ asset('/multiselect/js/popper.min.js') }}"></script>
<script src="{{ asset('/multiselect/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/multiselect/js/jquery.multiselect.js') }}"></script>
<script src="{{ asset('/multiselect/js/main.js') }}"></script>
<!-- multiselect -->

<script type="text/javascript" src="{{ asset('/js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/select2/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/jquery-multi-select/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {

        //wysihtml5 start
        $('.wysihtml5').wysihtml5({
            "link": false,
            "image": false
        });
        //wysihtml5 end

        $("#sale_start_date").datepicker({
            todayBtn: 1,
            format: 'yyyy-mm-dd',
            autoclose: true
        }).on('changeDate', function(selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#sale_end_date').datepicker('setStartDate', minDate);
        });

        $("#sale_end_date").datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            })
            .on('changeDate', function(selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('#sale_start_date').datepicker('setEndDate', maxDate);
            });
    });
    $(".select2, .select2-multiple").select2({
        placeholder: "Select"
    });
    $(document).ready(function() {
        $('.datepicker').datepicker({
            startDate: '{{date("Y-m-d H:i:s")}}',
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        $('.number').keypress(function(event) {
            if (event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {
                return true;
            } else if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $('#voucher_value').blur(function() {
            var type = $('#discount_type').val();
            if (type == 1) {
                if (parseInt($(this).val()) > 100) {
                    $(this).val('');
                    alert('Please enter the valid value.')
                }
            }
        });
    });

    function getDiscountType(type) {
        if (type) {
            $('#voucher_value').attr("disabled", false);
            $('#voucher_value').val('');
            if (type == 1) {
                $('#max_discount_amt_lbl').show();
                $('#voucher_value_lbl').html('Voucher Value (%)<span class="text-danger">*</span>');
            } else if (type == 2) {
                $('#max_discount_amt_lbl').hide();
                $('#max_discount_amount').val(0.00);
                $('#voucher_value_lbl').html('Voucher Value (RM)<span class="text-danger">*</span>');
            }
        } else {
            $('#voucher_value').attr("disabled", true);
            $('#voucher_value').val('');
        }
    }
</script>
@endsection