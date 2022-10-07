@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Category
            <span class="tools pull-right">
              <a href="{{ route('category.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('category.update',['category' => $categoryInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}   
                <div class="form-group @error('category_name') has-error @enderror">
                    <label for="category_name" class="col-lg-4 col-sm-4 control-label">Category Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="category_name" value="{{ $categoryInfo->category_name }}" id="category_name" placeholder="Category Name">
                         @if($errors->has('category_name'))
                            <p class="help-block">{{ $errors->first('category_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, $categoryInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('category.index') }}" class="btn btn-warning">Cancel</a>
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