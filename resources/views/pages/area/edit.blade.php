@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Area
            <span class="tools pull-right">
              <a href="{{ route('area.index') }}" title="Back" class="btn btn-primary btn-sm">
                <i class="fa fa-reply"></i>
              </a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('area.update',['area' => $areaInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}   
                <div class="form-group @error('area_name') has-error @enderror">
                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Area Name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="area_name" value="{{ $areaInfo->area_name }}" id="inputEmail1" placeholder="Area Name">
                         @if($errors->has('area_name'))
                            <p class="help-block">{{ $errors->first('area_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('pincode') has-error @enderror">
                    <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Pincode</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="pincode" value="{{ $areaInfo->pincode }}" id="inputPassword1" placeholder="Pincode">
                        @if($errors->has('pincode'))
                            <p class="help-block">{{ $errors->first('pincode') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label">Status</label>
                    <div class="col-lg-10">
                        {!! Form::select('status', $status, $areaInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Update Area</button>
                        <a href="{{ route('area.index') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
</div><!-- page end-->
@endsection
@section('scripts')

@endsection