@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Add User Information
            <span class="tools pull-right">
              <a href="{{ route('user.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('user.store') }}">
                @csrf
                <div class="form-group @error('full_name') has-error @enderror">
                    <label for="full_name" class="col-lg-4 col-sm-4 control-label">Full Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name">
                         @if($errors->has('full_name'))
                            <p class="help-block">{{ $errors->first('full_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('user_name') has-error @enderror">
                    <label for="user_name" class="col-lg-4 col-sm-4 control-label">User Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="user_name" id="user_name" placeholder="User Name">
                         @if($errors->has('user_name'))
                            <p class="help-block">{{ $errors->first('user_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('email') has-error @enderror">
                    <label for="email" class="col-lg-4 col-sm-4 control-label">Email</label>
                    <div class="col-lg-8">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                         @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('password') has-error @enderror">
                    <label for="password" class="col-lg-4 col-sm-4 control-label">Password <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="password" id="password" value="{{$password}}" placeholder="Password">
                         @if($errors->has('password'))
                            <p class="help-block">{{ $errors->first('password') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="user_image">Image</label>
                  <div class="col-md-8">
                      <input type='file' id="user_image" name="user_image" class="form-control" accept="image/*" />
                  </div>
                </div>
                <div class="form-group @error('roleId') has-error @enderror">
                    <label class="col-lg-4 col-sm-4 control-label" for="roleId">Role <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="roleId" name="roleId" class="form-control" size="1">
                            <option value="" disabled="disabled" selected> -- Select Role -- </option>
                            @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, null, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Add User</button>
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