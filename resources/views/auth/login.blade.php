@extends('layouts.layout_login')
@section('content')
<form class="form-signin" action="{{ route('login') }}" method="POST" autocomplete="off">
{{ csrf_field() }}
<h2 class="form-signin-heading"><img src="https://bungkuskawkaw.com/wp-content/uploads/2019/01/Bungkus-Logo-300x177.png" width="168" height="80"></h2>
<div class="login-wrap">
    <div class="user-login-info">
        <div class="form-group @error('email') has-error @enderror">
        <input type="email" name="email" value="{{ old('email') }}"  class="form-control" placeholder="User ID" autofocus>
        @error('email')
            {{ $message }}
        @enderror
        </div>
        <div class="form-group @error('password') has-error @enderror">
        <input type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="Password">
        @error('password')
            <p>{{ $message }}</p>
        @enderror
        </div>
    </div>
    <label class="checkbox">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember me
        <span class="pull-right">
            <a data-toggle="modal" href="{{ route('password.request') }}"> Forgot Password?</a>

        </span>
    </label>
    <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>

    <!--<div class="registration">
        Don't have an account yet?
        <a class="" href="registration.html">
            Create an account
        </a>
    </div>-->
</div>
</form>
@endsection