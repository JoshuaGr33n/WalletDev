@extends('layouts.layout_admin')
@section('style')
<!--dynamic table-->
    <link rel="stylesheet" href="{{ asset('/js/bootstrap-datepicker/css/datepicker.css') }}" />
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Update Merchant Information
            <span class="tools pull-right">
              <a href="{{ route('merchant.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="box box-primary">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('merchant.update',['merchant' => $merchantInfo->id ]) }}">
                @csrf
                {{method_field('PUT')}}
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group @error('company_name') has-error @enderror">
                        <label for="company_name" class="col-sm-4 control-label">Company Name<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Company Name" value="{{ $merchantInfo->company_name }}">
                          @if($errors->has('company_name'))
                            <p class="help-block">{{ $errors->first('company_name') }}</p>
                          @endif
                        </div>
                      </div>
                      <div class="form-group @error('reg_no') has-error @enderror">
                        <label for="reg_no" class="col-sm-4 control-label">Company RegNo<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="reg_no" id="reg_no" placeholder="Company RegNo" value="{{ $merchantInfo->company_name }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="merchant_email" class="col-sm-4 control-label">Contact Email</label>
                        <div class="col-sm-8">
                          <input type="email" placeholder="Email" name="merchant_email" id="merchant_email" class="form-control" value="{{ $merchantInfo->merchant_email }}">
                        </div>
                      </div>
                      <div class="form-group @error('merchant_category') has-error @enderror">
                        <label for="merchant_category" class="col-sm-4 control-label">Merchant Category<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            {!! Form::select('merchant_category', $category, $merchantInfo->merchant_category, ['class' => 'form-control m-bot15']) !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Merchant Logo</label>
                        <div class="col-sm-8">
                            <input type='file' id="merchant_logo" name="merchant_logo" class="form-control" accept="image/*" />
                            @if($merchantInfo->merchant_logo)
                                <img src="{{ asset('uploads/merchants/'.$merchantInfo->merchant_logo) }}" id="user_image" style="height:120px;width: auto;">
                            @endif
                            <input type='hidden' id="current_merchant_logo" name="current_merchant_logo" value="{{ $merchantInfo->merchant_logo }}" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6 @error('contact_name') has-error @enderror">
                      <div class="form-group">
                        <label for="contact_name" class="col-sm-4 control-label">Main Contact name<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="contact_name" id="contact_name" placeholder="Contact name" value="{{ $merchantInfo->contact_name }}">
                        </div>
                      </div>
                      <div class="form-group @error('contact_phone') has-error @enderror">
                        <label for="contact_phone" class="col-sm-4 control-label">Main Contact number<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control number" maxlength="12" name="contact_phone" id="contact_phone" placeholder="Contact number" value="{{ $merchantInfo->contact_phone }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="address" class="col-sm-4 control-label">Residential Address</label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="address" id="address" placeholder="Residential Address" value="{{ $merchantInfo->address }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="post_code" class="col-sm-4 control-label">Postal Code</label>
                        <div class="col-sm-8">
                          <input type="text" maxlength="6" class="form-control number" name="post_code" id="post_code" placeholder="Postal Code" value="{{ $merchantInfo->post_code }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label">Status</label>
                        <div class="col-lg-8">
                            {!! Form::select('status', $status, $merchantInfo->status, ['class' => 'form-control m-bot15']) !!}
                        </div>
                    </div>
                      <div class="form-group">
                        <label for="description" class="col-sm-4 control-label">Description</label>
                        <div class="col-sm-8">
                          <textarea class="form-control" name="description" id="description">{{ $merchantInfo->description }}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <h3>Outlets Details</h3>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group @error('outlet_address') has-error @enderror">
                        <label for="outlet_address" class="col-sm-2 control-label">Outlet Address<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_address" id="outlet_address" placeholder="Outlet Address" value="{{ $outletInfo->outlet_address }}">
                          <div class="map_loc" id="map_loc2"></div>
                        </div>
                        <div class="col-sm-2">
                          <input type="button" class="btn btn-sm btn-primary" id="getLocation" value="Get Current Location"/>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group @error('outlet_name') has-error @enderror">
                        <label for="outlet_name" class="col-sm-4 control-label">Outlet Name<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_name" id="outlet_name" placeholder="Outlet Name" value="{{ $outletInfo->outlet_name }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_latitude') has-error @enderror">
                        <label for="outlet_latitude" class="col-sm-4 control-label">Address Latitude<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_latitude" id="outlet_latitude" placeholder="Address Latitude" value="{{ $outletInfo->outlet_latitude }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_phone') has-error @enderror">
                        <label for="outlet_phone" class="col-sm-4 control-label">Outlet Phone Number<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" placeholder="Outlets Phone number" name="outlet_phone" id="outlet_phone" maxlength="12" class="number form-control" value="{{ $outletInfo->outlet_phone }}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="outlet_email" class="col-sm-4 control-label">Outlet Email</label>
                        <div class="col-sm-8">
                          <input type="email" placeholder="Outlets Email" name="outlet_email" id="outlet_email" maxlength="60" class="form-control" value="{{ $outletInfo->outlet_email }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_longitude') has-error @enderror">
                        <label for="outlet_longitude" class="col-sm-4 control-label">Address Longitude<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_longitude" id="outlet_longitude" placeholder="Address Longitude" value="{{ $outletInfo->outlet_longitude }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_hours') has-error @enderror">
                        <label for="outlet_hours" class="col-sm-4 control-label">Outlets Hours<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_hours" id="outlet_hours" placeholder="09am - 10pm" value="{{ $outletInfo->outlet_hours }}">
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-md-offset-2 col-md-10">
                      <input type="hidden" id="merchant_id" name="merchant_id" value="{{ $merchantInfo->id }}">
                      <input type="hidden" id="outlet_id" name="outlet_id" value="{{ $outletInfo->id }}">
                      <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('merchant.index') }}" class="btn btn-warning">Cancel</a>
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
<script type="text/javascript">
$(document).ready(function(){
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true
  });
});
</script>
@endsection