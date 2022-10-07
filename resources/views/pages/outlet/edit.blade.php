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
            Update Outlet Information
            <span class="tools pull-right">
              <a href="{{ route('outlet.index',['merchant_id'=>$outletInfo->merchant_id]) }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="box box-primary">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('outlet.update',['outlet' => $outletInfo->id ]) }}">
                @csrf
                {{method_field('PUT')}}
                <div class="box-body">
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
                      <div class="form-group">
                        <label for="outlet_email" class="col-sm-4 control-label">Outlet Email</label>
                        <div class="col-sm-8">
                          <input type="email" placeholder="Outlets Email" name="outlet_email" id="outlet_email" maxlength="60" class="form-control" value="{{ $outletInfo->outlet_email }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Outlet Logo</label>
                        <div class="col-sm-8">
                            <input type='file' id="outlet_logo" name="outlet_logo" class="form-control" accept="image/*" />
                            @if($outletInfo->outlet_logo)
                                <img src="{{ asset('uploads/outlets/'.$outletInfo->outlet_logo) }}" id="user_image" style="height:120px;width: auto;">
                            @endif
                            <input type='hidden' id="current_outlet_logo" name="current_outlet_logo" value="{{ $outletInfo->outlet_logo }}" />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group @error('outlet_longitude') has-error @enderror">
                        <label for="outlet_longitude" class="col-sm-4 control-label">Address Longitude<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_longitude" id="outlet_longitude" placeholder="Address Longitude" value="{{ $outletInfo->outlet_longitude }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_phone') has-error @enderror">
                        <label for="outlet_phone" class="col-sm-4 control-label">Outlet Phone Number<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" placeholder="Outlets Phone number" name="outlet_phone" id="outlet_phone" maxlength="12" class="number form-control" value="{{ $outletInfo->outlet_phone }}">
                        </div>
                      </div>
                      <div class="form-group @error('outlet_hours') has-error @enderror">
                        <label for="outlet_hours" class="col-sm-4 control-label">Outlets Hours<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" name="outlet_hours" id="outlet_hours" placeholder="09am - 10pm" value="{{ $outletInfo->outlet_hours }}">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-lg-4 col-sm-4 control-label">Status</label>
                        <div class="col-lg-8">
                            {!! Form::select('status', $status, $outletInfo->status, ['class' => 'form-control m-bot15']) !!}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-md-offset-2 col-md-10">
                      <input type="hidden" id="merchant_id" name="merchant_id" value="{{ $outletInfo->merchant_id }}">
                      <input type="hidden" id="outlet_id" name="outlet_id" value="{{ $outletInfo->id }}">
                      <button type="submit" class="btn btn-primary">Update</button>
                      <a href="{{ route('outlet.index',['merchant_id'=>$outletInfo->merchant_id]) }}" class="btn btn-warning">Cancel</a>
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