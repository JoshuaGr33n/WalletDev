@extends('layouts.layout_admin')
@section('content')
<!-- page start-->
<div class="col-lg-12">
    <section class="panel">
        <header class="panel-heading">
            Edit Menu
            <span class="tools pull-right">
              <a href="{{ route('menu.index') }}" title="Back" class="btn btn-primary btn-sm"><i class="fa fa-reply"></i></a>
            </span>
        </header>
        <div class="panel-body">
            <div class="position-center">
                <form class="form-horizontal" autocomplete="off" role="form" enctype="multipart/form-data" method="POST" action="{{ route('menu.update',['category' => $menuInfo->id ]) }}">
                 @csrf
                 {{method_field('PUT')}}

                <div class="form-group @error('category_id') has-error @enderror">
                    <label class="col-lg-4 col-sm-4 control-label" for="category_id">Category <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="category_id" name="category_id" class="form-control m-bot15" size="1">
                            <option value="0" disabled="disabled" selected> -- Select Category -- </option>
                            @foreach($Categorys as $Category)
                                <option value="{{$Category->id}}" @if($Category->id == $menuInfo->category_id) selected="selected" @endif>{{$Category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group @error('sub_category_id') has-error @enderror">
                    <label class="col-lg-4 col-sm-4 control-label" for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <select id="sub_category_id" name="sub_category_id" class="form-control m-bot15" size="1">
                            <option value="0" disabled="disabled" selected> -- Select Sub Category -- </option>
                            @foreach($Subcategorys as $Category)
                                <option value="{{$Category->id}}" @if($Category->id == $menuInfo->sub_category_id) selected="selected" @endif>{{$Category->sub_category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group @error('item_name') has-error @enderror">
                    <label for="item_name" class="col-lg-4 col-sm-4 control-label">Item Name <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="item_name" id="item_name" value="{{ $menuInfo->item_name }}" placeholder="Item Name">
                         @if($errors->has('item_name'))
                            <p class="help-block">{{ $errors->first('item_name') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="item_image">Image</label>
                  <div class="col-md-8">
                        <input type='file' id="item_image" name="item_image" class="form-control" accept="image/*" />
                        @if($menuInfo->item_image)
                            <img src="{{ asset('uploads/menus/'.$menuInfo->item_image) }}" id="user_image" style="height:120px;width: auto;">
                        @endif
                        <input type='hidden' id="current_item_image" name="current_item_image" value="{{ $menuInfo->item_image }}" />
                  </div>
                </div>
                <div class="form-group @error('item_best_price') has-error @enderror">
                    <label for="item_best_price" class="col-lg-4 col-sm-4 control-label">Item Best Price <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="item_best_price" id="item_best_price" value="{{ $menuInfo->item_best_price }}" placeholder="Item Best Price">
                         @if($errors->has('item_best_price'))
                            <p class="help-block">{{ $errors->first('item_best_price') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('upc_code') has-error @enderror">
                    <label for="upc_code" class="col-lg-4 col-sm-4 control-label">UPC Code <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="upc_code" id="upc_code" value="{{ $menuInfo->upc_code }}" placeholder="UPC Code">
                         @if($errors->has('upc_code'))
                            <p class="help-block">{{ $errors->first('upc_code') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group @error('product_id') has-error @enderror">
                    <label for="product_id" class="col-lg-4 col-sm-4 control-label">Product ID <span class="text-danger">*</span></label>
                    <div class="col-lg-8">
                        <input type="text" class="form-control" name="product_id" id="product_id" value="{{ $menuInfo->product_id }}" placeholder="Product ID">
                         @if($errors->has('product_id'))
                            <p class="help-block">{{ $errors->first('product_id') }}</p>
                         @endif
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-lg-4 col-sm-4 control-label" for="item_description">Item Description</label>
                  <div class="col-md-8">
                    <textarea rows="3" id="item_description" name="item_description" class="form-control" placeholder="Description">{{ $menuInfo->item_description }}</textarea>
                  </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-4 col-sm-4 control-label">Status</label>
                    <div class="col-lg-8">
                        {!! Form::select('status', $status, $menuInfo->status, ['class' => 'form-control m-bot15']) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-4 col-lg-8">
                        <button type="submit" class="btn btn-primary">Update Menu</button>
                        <a href="{{ route('menu.index') }}" class="btn btn-warning">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
</div><!-- page end-->
@endsection
@section('scripts')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).on('change', "#category_id", function (evt) {
    var category_id = $(this).val();
    if(category_id){
        $.ajax({
            type  : 'POST',
            url: "{{ route('getSubcategory') }}",
            data  : {'category_id': category_id},
            dataType: "html",
            success : function( html ) {
                $('#sub_category_id').html(html);
            }
        });
    }
});
</script>
@endsection