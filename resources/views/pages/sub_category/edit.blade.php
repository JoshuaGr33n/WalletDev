@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Sub Category
            <span class="tools pull-right">
              <a href="{{ route('subcategory.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" method="POST" action="{{ route('subcategory.update',['category' => $subCategoryInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}   
                <div class="form-group @error('sub_category_name') has-error @enderror">
                    <label for="sub_category_name" class="col-lg-4 col-sm-4 control-label">Category Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="sub_category_name" value="{{ $subCategoryInfo->sub_category_name }}" id="sub_category_name" placeholder="Category Name">
                         @if($errors->has('sub_category_name'))
                            <p class="help-block">{{ $errors->first('sub_category_name') }}</p>
                         @endif
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Parent Category</label>
                    <div class="col-lg-8">
                        <select id="category_id" name="category_id" class="form-control m-bot15" size="1">
                            <option value="0" disabled="disabled"> -- Select Category -- </option>
                            @foreach($Categorys as $Category)
                                <option value="{{$Category->id}}" @if($Category->id == $subCategoryInfo->category_id) selected="selected" @endif>{{$Category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, $subCategoryInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update Sub Category</button>
                        <a href="{{ route('subcategory.index') }}" class="btn btn-warning">Cancel</a>
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