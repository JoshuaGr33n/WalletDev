@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
<link rel="stylesheet" href="{{ asset('/js/bootstrap-datepicker/css/datepicker.css') }}" />
<link href="{{ asset('/js/select2/select2.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/js/jquery-multi-select/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" />
<style type="text/css">
  .select2-container {
    width: 100%;
  }
</style>
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
  <section class="panel">
    <header class="panel-heading">
      Add voucher Information
      <span class="tools pull-right">
        <a href="{{ route('vouchers.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
      </span>
    </header>
    <div class="panel-body">
      <div class="box box-primary">
        <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('vouchers.store') }}">
          @csrf
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group @error('voucher_type') has-error @enderror">
                  <label for="voucher_type" class="col-sm-4 control-label">Voucher Type<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <select name="voucher_type" id="voucher_type" class="form-control">
                      @foreach($vouchertype_list as $vouchertype)
                      <option value="{{$vouchertype->id}}">{{$vouchertype->type_name}} - {{$vouchertype->type_id}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group @error('voucher_name') has-error @enderror">
                  <label for="voucher_name" class="col-sm-4 control-label">Voucher Name<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="voucher_name" id="voucher_name" value="{{old('voucher_name')}}" placeholder="Voucher Name">
                    @if($errors->has('voucher_name'))
                    <p class="help-block">{{ $errors->first('voucher_name') }}</p>
                    @endif
                  </div>
                </div>
                <div class="form-group @error('outlet_ids') has-error @enderror">
                  <label for="outlet_ids" class="col-sm-4 control-label">Outlet<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <select name="outlet_ids[]" id="outlet_ids" class="select2-multiple" tabindex="-1" multiple style="min-width: 315px;">
                      <option value="all">All</option>
                      @foreach($outlet_lists as $outlet)
                      <option value="{{$outlet->id}}">{{$outlet->outlet_name}}</option>
                      @endforeach
                    </select>

                    @error('outlet_ids')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>

                <div class="form-group @error('sale_start_date') has-error @enderror">
                  <label for="sale_start_date" class="col-sm-4 control-label">Sale Start Date<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="sale_start_date" id="sale_start_date" value="{{old('sale_start_date')}}" placeholder="Sale Start Date">
                    @error('sale_start_date')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('sale_end_date') has-error @enderror">
                  <label for="sale_end_date" class="col-sm-4 control-label">Sale End Date<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="sale_end_date" id="sale_end_date" value="{{old('sale_end_date')}}" placeholder="Sale End Date">
                    @error('sale_end_date')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('validity_period') has-error @enderror">
                  <label for="validity_period" class="col-sm-4 control-label">Validity Period<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control number" name="validity_period" id="validity_period" value="{{old('validity_period')}}" placeholder="Validity Period">
                    @error('validity_period')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('applicable_to_items') has-error @enderror">
                  <label for="applicable_to_items" class="col-sm-4 control-label">Voucher Applicable To Items<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <select name="applicable_to_items[]" id="applicable_to_items" class="select2-multiple" tabindex="-1" multiple style="min-width: 315px;">
                      <option value="all">All</option>
                      @foreach($item_lists as $item)
                      <option value="{{$item->id}}">{{$item->item_name}}</option>
                      @endforeach
                    </select>
                    @error('applicable_to_items')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label for="tAndC" class="col-sm-4 control-label">tAndC</label>
                  <div class="col-sm-8">
                    <textarea class="wysihtml5 form-control" name="tAndC" id="tAndC" rows="5">{{old('tAndC')}}</textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label for="voucher_image" class="col-md-4 control-label">Voucher Logo</label>
                  <div class="col-sm-8">
                    <input type='file' id="voucher_image" name="voucher_image" class="form-control" accept="image/*" />
                  </div>
                </div>

              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="discount_type" class="col-lg-4 col-sm-4 control-label">Discount Type</label>
                  <div class="col-lg-8">
                    {!! Form::select('discount_type', $discountType, null, ['id'=>'discount_type', 'class' => 'form-control', 'onchange' => "getDiscountType(this.value);"]) !!}
                  </div>
                </div>
                <div class="form-group @error('voucher_value') has-error @enderror">
                  <label for="voucher_value" id="voucher_value_lbl" class="col-sm-4 control-label">Voucher Value (%)<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" maxlength="4" class="form-control number" name="voucher_value" id="voucher_value" value="{{old('voucher_value')}}" placeholder="Voucher Value">
                    @error('voucher_value')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div id="max_discount_amt_lbl" class="form-group @error('max_discount_amount') has-error @enderror">
                  <label for="max_discount_amount" class="col-sm-4 control-label">Max Voucher Value (RM)<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" maxlength="4" class="form-control number" name="max_discount_amount" id="max_discount_amount" value="{{old('max_discount_amount')}}" placeholder="Ex: 5.00">
                  </div>
                </div>
                <div class="form-group">
                  <label for="buy_voucher_with" class="col-lg-4 col-sm-4 control-label">Buy Voucher With<span class="text-danger">*</span></label>
                  <div class="col-lg-8">
                    {!! Form::select('buy_voucher_with', $buyVoucherWith, null, ['id'=>'buy_voucher_with', 'class' => 'form-control', 'onchange' => "buyWith(this.value);"]) !!}
                  </div>
                </div>
                <div class="form-group" id="buy_voucher_with_points">
                  <label for="buy_voucher_with_points_value" class="col-sm-4 control-label">Total Required Points</label>
                  <div class="col-sm-8">
                    <input type="text" name="buy_voucher_with_points_value" id="buy_voucher_with_points_value" class="form-control number" value="{{old('buy_voucher_with_points_value')}}" placeholder="Total Required Points">
                    <div id="msg"></div>
                  </div>
                </div>
                <div class="form-group" id="buy_voucher_with_wallet_credits">
                  <label for="buy_voucher_with_wallet_credits_value" class="col-sm-4 control-label">Total Required Wallet Credits</label>
                  <div class="col-sm-8">
                    <input type="text" name="buy_voucher_with_wallet_credits_value" id="buy_voucher_with_wallet_credits_value" class="form-control number" value="{{old('buy_voucher_with_wallet_credits_value')}}" placeholder="Total Required Wallet Credit">
                  </div>
                </div>

                <div class="form-group @error('max_qty') has-error @enderror">
                  <label for="max_qty" class="col-sm-4 control-label">Max Qty <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="max_qty" id="max_qty" class="form-control number" value="{{old('max_qty')}}" placeholder="Max Qty">
                    @error('max_qty')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('single_user_qty') has-error @enderror">
                  <label for="single_user_qty" class="col-sm-4 control-label">Single User Qty <span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" name="single_user_qty" id="single_user_qty" class="form-control number" value="{{old('single_user_qty')}}" placeholder="Single User Qty">
                    @error('single_user_qty')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group @error('voucher_description') has-error @enderror">
                  <label for="voucher_description" class="col-sm-4 control-label">Description<span class="text-danger">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="wysihtml5 form-control" name="voucher_description" id="voucher_description" rows="5">{{old('voucher_description')}}</textarea>
                    @error('voucher_description')
                    <p class="help-block">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label">Status</label>
                  <div class="col-lg-8">
                    {!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
                  </div>
                </div>



                <div class="form-group">
                  <input class="form-check-input" type="checkbox" name="birthday" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault">Birthday Voucher</label>
                </div>
                <div class="form-group">
                  <input class="form-check-input" type="checkbox" name="welcome" id="flexCheckDefault" />
                  <label class="form-check-label" for="flexCheckDefault">Welcome Voucher</label>
                </div>

              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="col-md-offset-2 col-md-10">
                <input type="hidden" value="" id="voucher_id" name="voucher_id">
                <button type="submit" class="btn btn-primary submit">Create</button>
                <a href="{{ route('vouchers.index') }}" class="btn btn-warning">Cancel</a>
              </div>
            </div>

        </form>
      </div>
    </div>
  </section>
</div><!-- page end-->
@endsection
@section('scripts')
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
        $('#voucher_value_lbl').html('Voucher Value (RM)<span class="text-danger">*</span>');
      }
    } else {
      $('#voucher_value').attr("disabled", true);
      $('#voucher_value').val('');
    }
  }


  window.onload = function() {
    document.getElementById('buy_voucher_with_wallet_credits').style.display = 'none';
    document.getElementById('buy_voucher_with_points').style.display = 'none';
    // document.getElementById('msg').style.display = 'none';
  };

  function buyWith(criteria) {
    if (criteria) {
      if (criteria == 1) {
        $('#buy_voucher_with_points').show();
        $('#buy_voucher_with_wallet_credits').hide();

      } else if (criteria == 2) {
        $('#buy_voucher_with_wallet_credits').show();
        $('#buy_voucher_with_points').hide();

      } else {
        $('#buy_voucher_with_points').show();
        $('#buy_voucher_with_wallet_credits').show();
      }
    } else {}
  }



  $("#buy_voucher_with").focusout(function() {
    if ($(this).val() == 1) {


      if ($('#buy_voucher_with_points_value').val().length < 1) {
          $('#buy_voucher_with_points_value').focus();
          $('#msg').html('<span class="text-danger">This Field is required</span>');
      } else {
          $('#msg').hide();
      }

    } else if ($(this).val() == 2) {
      $('#buy_voucher_with_wallet_credits_value').attr('required', '');
      $('#buy_voucher_with_points_value').removeAttr('required', '');
      // $('#buy_voucher_with_wallet_credits_value').attr('data-error', 'Required.');

    } else if ($(this).val() == 3) {
      $('#buy_voucher_with_points_value').attr('required', '');
      // $('#buy_voucher_with_points_value').attr('data-error', 'Required.');

      $('#buy_voucher_with_wallet_credits_value').attr('required', '');
      // $('#buy_voucher_with_wallet_credits_value').attr('data-error', 'Required.');
    }
  });
  $("#buy_voucher_with").trigger("change");
</script>
@endsection