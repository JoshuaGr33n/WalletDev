@extends('layouts.layout_admin')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/select2/select2.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/js/bootstrap-wysihtml5/bootstrap-wysihtml5.css') }}" />
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Send Notification
            <span class="tools pull-right">
              <a href="{{ route('notification.index') }}" title="Back" class="btn btn-primary btn-sm">
                <i class="fa fa-reply"></i>
              </a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('notification.store') }}">
                 @csrf
                <div class="form-group @error('notify_to') has-error @enderror">
                    <label for="notify_to" class="col-lg-3 col-sm-3 control-label">Notify To <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <select multiple id="notify_to" name="notify_to[]" class="m-bot15 populate" size="1" style="width:100%">
                            <option value="0">All</option>
                            @foreach($userlists as $user)
                                <option value="{{$user->id}}">{{$user->first_name}} ({{$user->email}})</option>
                            @endforeach
                        </select>
                         @if($errors->has('notify_to'))
                            <p class="help-block">{{ $errors->first('notify_to') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('title') has-error @enderror">
                    <label for="title" class="col-lg-3 col-sm-3 control-label">Title <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <input type="text"  class="form-control" name="title" id="title" placeholder="Title">
                        @if($errors->has('title'))
                            <p class="help-block">{{ $errors->first('title') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group @error('short_desc') has-error @enderror">
                    <label for="short_desc" class="col-lg-3 col-sm-3 control-label">Short Description <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea  class="form-control" name="short_desc" id="short_desc" placeholder="Short Description"></textarea>
                        @if($errors->has('short_desc'))
                            <p class="help-block">{{ $errors->first('short_desc') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group @error('description') has-error @enderror">
                    <label for="description" class="col-lg-3 col-sm-3 control-label">Description <span class="text-danger">*</span></label>
                    <div class="col-lg-9">
                        <textarea  class="wysihtml5 form-control" name="description" id="description" rows="5" placeholder="Description"></textarea>
                        @if($errors->has('description'))
                            <p class="help-block">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="notification_icon" class="col-md-3 control-label">Notification Icon</label>
                    <div class="col-sm-9">
                        <input type='file' id="notification_icon" name="notification_icon" class="form-control" accept="image/*" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                        <a href="{{ route('notification.index') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
</div><!-- page end-->
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('/js/select2/select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-wysihtml5/wysihtml5-0.3.0.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/bootstrap-wysihtml5/bootstrap-wysihtml5.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {

    $("#notify_to").select2({
        placeholder: "Select a User",
        allowClear: true
    });
    //wysihtml5 start
    $('.wysihtml5').wysihtml5();
});
</script>
@endsection