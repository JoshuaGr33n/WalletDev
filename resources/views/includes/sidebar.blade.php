<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
            <li>
                <a class="{{ (strpos(Route::currentRouteName(), 'dashboard.index') === 0) ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('appuser*') ? 'active' : '' }}" href="{{ route('appuser.index') }}">
                    <i class="fa fa-building-o"></i>
                    <span>Manage AppUsers</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('area*') ? 'active' : '' }}" href="{{ route('area.index') }}">
                    <i class="fa fa-building-o"></i>
                    <span>Manage Areas</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="" href="javascript:;" class="">
                    <i class="fa fa-sitemap"></i>
                    <span>Category & Menu</span>
                </a>
                <ul class="sub">
                    <li class="{{ Request::routeIs('category*') ? 'active' : '' }}"><a href="{{ route('category.index') }}"><i class="fa fa-plus-square-o"></i> Manage Category</a></li>
                    <li class="{{ Request::routeIs('subcategory*') ? 'active' : '' }}"><a href="{{ route('subcategory.index') }}"><i class="fa fa-plus-square"></i> Manage Sub Category</a></li>
                    <li class="{{ Request::routeIs('menu*') ? 'active' : '' }}"><a href="{{ route('menu.index') }}"><i class="fa fa-check-square"></i> Manage Menu</a></li>
                </ul>
            </li>
            <li>
                <a class="{{ Request::routeIs('merchant*') ? 'active' : '' }}" href="{{ route('merchant.index') }}">
                    <i class="fa fa-suitcase"></i>
                    <span>Manage Merchant</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('announcement*') ? 'active' : '' }}" href="{{ route('announcement.index') }}">
                    <i class="fa fa-building-o"></i>
                    <span>Manage Announcements</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('vouchertype*') ? 'active' : '' }}" href="{{ route('vouchertype.index') }}">
                    <i class="fa fa-building-o"></i>
                    <span>Manage Voucher Type</span>
                </a>
            </li>
            <li>
                <a class="{{ (request()->is('vouchers*')) ? 'active' : '' }}" href="{{ route('vouchers.index') }}">
                    <i class="fa fa-building-o"></i>
                    <span>Manage Vouchers</span>
                </a>
            </li>
            <li class="nav-item">
              <a href="users" class="nav-link nav-toggle">
                  <i class="fa fa-users"></i>
                  <span class="title">Users</span>
                  <span class="arrow "></span>
              </a>
              <ul class="sub">
                <li class="{{ Request::routeIs('user*') ? 'active' : '' }}"><a href="{{ route('user.create') }}"><i class="fa fa-plus-circle"></i> Add User</a></li>
                <li class="{{ Request::routeIs('user*') ? 'active' : '' }}"><a href="{{ route('user.index') }}"><i class="fa fa-list"></i> User Lists</a></li>
                <li class="{{ Request::routeIs('role*') ? 'active' : '' }}"><a href="{{ route('role.index') }}"><i class="fa fa-users"></i> User Role</a></li>
              </ul>
            </li>
            <li>
                <a class="{{ Request::routeIs('setting*') ? 'active' : '' }}" href="{{ route('setting.index') }}">
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('notification*') ? 'active' : '' }}" href="{{ route('notification.index') }}">
                    <i class="fa fa-bell"></i>
                    <span>Notification</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('adminSettlement*') ? 'active' : '' }}" href="{{ route('adminSettlement.index') }}">
                    <i class="fa fa-list"></i>
                    <span>Admin Settlement</span>
                </a>
            </li>
            <li>
                <a class="{{ Request::routeIs('outletReport*') ? 'active' : '' }}" href="{{ route('outletReport.index') }}">
                    <i class="fa fa-list"></i>
                    <span>Report Module</span>
                </a>
            </li>
        </ul>
      </div>        
<!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->