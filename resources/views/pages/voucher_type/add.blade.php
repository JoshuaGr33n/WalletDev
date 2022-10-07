@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add Voucher Type Information
            <span class="tools pull-right">
              <a href="{{ route('vouchertype.index') }}" title="Back" class="btn btn-primary btn-sm">
                <i class="fa fa-reply"></i>
              </a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('vouchertype.store') }}">
                 @csrf
                <div class="form-group @error('type_name') has-error @enderror">
                    <label for="type_name" class="col-lg-2 col-sm-2 control-label">Type Name</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" name="type_name" id="type_name" maxlength="20" placeholder="Type Name">
                         @if($errors->has('type_name'))
                            <p class="help-block">{{ $errors->first('type_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('type_id') has-error @enderror">
                    <label for="type_id" class="col-lg-2 col-sm-2 control-label">Type ID</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control nospace" name="type_id" id="type_id" maxlength="10" placeholder="Type ID">
                        @if($errors->has('type_id'))
                            <p class="help-block">{{ $errors->first('type_id') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label">Status</label>
                    <div class="col-lg-10">
                        {!! Form::select('status', $status, null, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Add Voucher Type</button>
                        <a href="{{ route('vouchertype.index') }}" class="btn btn-warning">Cancel</a>
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