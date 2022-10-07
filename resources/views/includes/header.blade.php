<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="{{ url('/') }}" class="logo">
        <!-- {{ env('APP_NAME') }} ADMIN -->
        <img alt="" src="{{ asset('images/logo.png') }}" style="height: 32px;width: 168px;">
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{ asset('images/avatar1_small.jpg') }}">
                <span class="username">{{ ucwords(Auth::user()->name) }}</span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-key"></i> Log Out</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </li>
        <!-- user login dropdown end -->
        <!--<li>
            <div class="toggle-right-box">
                <div class="fa fa-bars"></div>
            </div>
        </li>-->
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->