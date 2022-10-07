@extends('layouts.layout_admin')
@section('style')
    <link rel="stylesheet" href="{{ asset('/js/select2/select2.css') }}" />
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Notification
            <span class="tools pull-right">
              <a href="{{ route('notification.index') }}" title="Back" class="btn btn-primary btn-sm">
                <i class="fa fa-reply"></i>
              </a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('notification.update',['area' => $notificationInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}   
                <div class="form-group @error('notify_to') has-error @enderror">
                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Notify To</label>
                    <div class="col-lg-10">
                        <select multiple id="notify_to" name="notify_to[]" class="m-bot15 populate" size="1" style="width:100%">
                            <option {{(($notificationInfo->notify_to ==0)?'selected':'')}} value="0">All</option>
                            @php $arrTo = explode(",",$notificationInfo->notify_to);@endphp
                            @foreach($userlists as $user)
                                <option @if(in_array($user->id,$arrTo)) selected @endif value="{{$user->id}}">{{$user->first_name}} ({{$user->email}})</option>
                            @endforeach
                        </select>
                         @if($errors->has('notify_to'))
                            <p class="help-block">{{ $errors->first('notify_to') }}</p>
                         @endif
                    </div>
                </div>

                <div class="form-group @error('message') has-error @enderror">
                    <label for="message" class="col-lg-2 col-sm-2 control-label">Message</label>
                    <div class="col-lg-10">
                        <textarea  class="form-control" name="message" id="message" placeholder="message">{{ $notificationInfo->message }}</textarea>
                        @if($errors->has('message'))
                            <p class="help-block">{{ $errors->first('message') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 col-sm-2 control-label">Status</label>
                    <div class="col-lg-10">
                        {!! Form::select('status', $status, $notificationInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-2 col-lg-10">
                        <button type="submit" class="btn btn-primary">Update Notification</button>
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
<script type="text/javascript">
$(document).ready(function() {
    $("#notify_to").select2({
        placeholder: "Select a User",
        allowClear: true
    });
});
</script>
@endsection