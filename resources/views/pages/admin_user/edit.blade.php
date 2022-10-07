@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit User
            <span class="tools pull-right">
              <a href="{{ route('user.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('user.update',['category' => $userInfo->id ]) }}">
                @csrf
                {{method_field('PUT')}}
                <div class="form-group @error('full_name') has-error @enderror">
                    <label for="full_name" class="col-lg-4 col-sm-4 control-label">Full Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="full_name" id="full_name" value="{{ $userInfo->full_name }}" placeholder="Full Name">
                         @if($errors->has('full_name'))
                            <p class="help-block">{{ $errors->first('full_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('user_name') has-error @enderror">
                    <label for="user_name" class="col-lg-4 col-sm-4 control-label">User Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="user_name" id="user_name" value="{{ $userInfo->user_name }}" placeholder="User Name">
                         @if($errors->has('user_name'))
                            <p class="help-block">{{ $errors->first('user_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('email') has-error @enderror">
                    <label for="email" class="col-lg-4 col-sm-4 control-label">Email</label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control" name="email" id="email" value="{{ $userInfo->email }}" placeholder="Email">
                         @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="user_image">Image</label>
                  <div class="col-md-8">
                        <input type='file' id="user_image" name="user_image" class="form-control" accept="image/*" />
                        @if($userInfo->user_image)
                            <img src="{{ asset('uploads/user_images/'.$userInfo->user_image) }}" id="user_image" style="height:120px;width: auto;">
                        @endif
                        <input type='hidden' id="current_user_image" name="current_user_image" value="{{ $userInfo->user_image }}" />
                  </div>
                </div>
                <div class="form-group @error('roleId') has-error @enderror">
                    <label class="col-lg-4 col-sm-4 control-label" for="roleId">Role <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="roleId" name="roleId" class="form-control" size="1">
                            <option value="" disabled="disabled" selected> -- Select Role -- </option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}" @if($role->id == $role_id) selected="selected" @endif>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, $userInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('user.index') }}" class="btn btn-warning">Cancel</a>
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