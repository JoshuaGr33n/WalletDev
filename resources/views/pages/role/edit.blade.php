@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Role
            <span class="tools pull-right">
              <a href="{{ route('role.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('role.update',['role' => $roleInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}   
                <div class="form-group @error('name') has-error @enderror">
                    <label for="name" class="col-lg-4 col-sm-4 control-label">Role Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="name" value="{{ $roleInfo->name }}" id="name" placeholder="role Name">
                         @if($errors->has('name'))
                            <p class="help-block">{{ $errors->first('name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('description') has-error @enderror">
                    <label for="description" class="col-lg-4 col-sm-4 control-label">Description <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="description" value="{{ $roleInfo->description }}" id="description" placeholder="Description">
                         @if($errors->has('description'))
                            <p class="help-block">{{ $errors->first('description') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update Role</button>
                        <a href="{{ route('role.index') }}" class="btn btn-warning">Cancel</a>
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