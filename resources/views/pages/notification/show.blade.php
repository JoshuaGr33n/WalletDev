@extends('layouts.layout_admin')
@section('style')
@endsection
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            View Notification
            <span class="tools pull-right">
              <a href="{{ route('notification.index') }}" title="Back" class="btn btn-primary btn-sm">
                <i class="fa fa-reply"></i>
              </a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                
                <div class="col-md-12">
                   <div class="profile-desk">
                       <div class="prf-box">
                            <h1></h1>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-4 col-xs-4">Notify To</div>
                                <div class="col-md-8 col-xs-8">
                                    <strong>
                                        @php
                                        if($notificationInfo->notify_to == 0){
                                            echo 'All ';
                                        }else{
                                            $userArr  = explode(',', $notificationInfo->notify_to);
                                            if($userArr){
                                                foreach($userArr as $user){
                                                    $userInfo = App\Models\User::where('id',$user)->first();
                                                    if($userInfo){ echo $userInfo->first_name.', '; }
                                                }
                                            }
                                        }
                                        @endphp
                                    </strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-4 col-xs-4">Title</div>
                                <div class="col-md-8 col-xs-8">
                                    <strong>{{$notificationInfo->title}}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-4 col-xs-4">Short Description</div>
                                <div class="col-md-8 col-xs-8">
                                    <strong>{{$notificationInfo->short_desc}}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-4 col-xs-4">Description</div>
                                <div class="col-md-8 col-xs-8">
                                    <strong>{{$notificationInfo->description}}</strong>
                                </div>
                            </div>
                            <div class=" wk-progress pf-status">
                                <div class="col-md-4 col-xs-4">Icon</div>
                                <div class="col-md-8 col-xs-8">
                                    @if($notificationInfo->notification_icon)
                                        <img src="{{ asset('uploads/notification/'.$notificationInfo->notification_icon) }}" style="height:45px;width: auto;">
                                    @endif
                                </div>
                            </div>
                        </div>
                   </div>
                </div>
            </div>
        </div>
    </section>
</div><!-- page end-->
@endsection
@section('scripts')
@endsection