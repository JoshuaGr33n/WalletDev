<div class="panel-body">
    <form class="form-horizontal" id="verifypassword_form" autocomplete="off" role="form" method="POST">
        @csrf
        <div class="form-group @error('password') has-error @enderror">
            <label for="user_name" class="col-lg-4 col-sm-4 control-label">Enter Password <span class="text-danger">*</span></label>
            <div class="col-lg-8">
                <input type="password" class="form-control" name="password" id="password" maxlength="12" placeholder="Password">
                 @if($errors->has('password'))
                    <p class="help-block">{{ $errors->first('password') }}</p>
                 @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-8">
            <input type="hidden" class="form-control" name="settlement_type" id="settlement_type" value="{{$settlement_type}}">
            <input type="hidden" class="form-control" name="amount" id="amount" value="{{$amount}}">
                <button type="button" class="btn btn-primary" onclick="return verifyPassword();">Verify Password</button>
                <button type="reset" class="btn btn-warning">Clear</button>
            </div>
        </div>
    </form>
</div>