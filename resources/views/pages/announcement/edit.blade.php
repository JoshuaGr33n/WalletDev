@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Announcement
            <span class="tools pull-right">
              <a href="{{ route('announcement.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('announcement.update',['category' => $announcementInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}

                <div class="form-group @error('title') has-error @enderror">
                    <label for="title" class="col-lg-4 col-sm-4 control-label">Title <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="title" id="title" value="{{ $announcementInfo->title }}" placeholder="Title">
                         @if($errors->has('title'))
                            <p class="help-block">{{ $errors->first('title') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="announcement_image">Image</label>
                  <div class="col-md-8">
                        <input type='file' id="announcement_image" name="announcement_image" class="form-control" accept="image/*" />
                        @if($announcementInfo->announcement_image)
                            <img src="{{ asset('uploads/announcements/'.$announcementInfo->announcement_image) }}" id="user_image" style="height:120px;width: auto;">
                        @endif
                        <input type='hidden' id="current_announcement_image" name="current_announcement_image" value="{{ $announcementInfo->announcement_image }}" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="description">Description</label>
                  <div class="col-md-8">
                    <textarea rows="3" id="description" name="description" class="form-control" placeholder="Description">{{ $announcementInfo->description }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, $announcementInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update Announcement</button>
                        <a href="{{ route('announcement.index') }}" class="btn btn-warning">Cancel</a>
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