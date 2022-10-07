<link rel="stylesheet" href="{{ asset('/js/iCheck/skins/square/green.css') }}" />
<div class="panel-body">
    <div class="col-lg-12">
        <p class="pull-right"><span class="label label-info">User : {{ (($userInfo)? $userInfo->first_name : '') }}</span></p>
    </div>
    <form class="form-horizontal" id="tranasaction_form" autocomplete="off" role="form" method="POST">
        @csrf
        <div class="form-group @error('transaction_type') has-error @enderror">
            <label for="full_name" class="col-lg-4 col-sm-4 control-label">Type <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <div class="col-sm-12 icheck">
                    <div class="square-green">
                        <div class="radio ">
                            <label>Topup <input tabindex="3" type="radio" id="type_1" name="transaction_type" value="1"></label>
                        </div>
                    </div>
                    <div class="square-green">
                        <div class="radio ">
                            <label>Pay <input tabindex="3" type="radio" id="type_1" name="transaction_type" value="2"></label>
                        </div>
                    </div>
                </div>
                 @if($errors->has('transaction_type'))
                    <p class="help-block">{{ $errors->first('transaction_type') }}</p>
                 @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-4 col-sm-4 control-label">Outlet <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <select id="outlet_id" name="outlet_id" class="form-control m-bot15" size="1">
                    <option value="0" disabled="disabled" selected> -- Select Outlet -- </option>
                    @foreach($outletLists as $outlet)
                        <option value="{{$outlet->id}}">{{$outlet->outlet_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group @error('amount') has-error @enderror">
            <label for="user_name" class="col-lg-4 col-sm-4 control-label">Amount <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="text" class="form-control number" name="amount" id="amount" maxlength="6" placeholder="Amount">
                 @if($errors->has('amount'))
                    <p class="help-block">{{ $errors->first('amount') }}</p>
                 @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-8">
                <input type="hidden" name="user_id" id="user_id" value="{{$user_id}}">
                <button type="button" class="btn btn-primary" onclick="return addTransaction();">Add Transaction</button>
                <button type="reset" class="btn btn-warning">Clear</button>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="{{ asset('/js/iCheck/jquery.icheck.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/icheck-init.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.number').keypress(function(event) {
    if (event.which == 8 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {
      return true;
    }else if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault();
    }
  });
});

</script>
