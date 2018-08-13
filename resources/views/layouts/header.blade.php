<header class="main-header">
  <!-- Logo -->
  <a href="{{route('home')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">
      <b>HSCN</b>
    </span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg">
      <b>HSCN</b>-CM</span>
  </a>
  <!-- Header Navbar -->
  <nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Notifications Menu -->
        <!-- User Account Menu -->
        <li class="dropdown user user-menu">
          <!-- Menu Toggle Button -->
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- The user image in the navbar-->
            <img src="{{ URL::to('/') . '/' . Auth::user()->avatar_url}}" class="user-image" alt="User Image">
            <!-- hidden-xs hides the username on small devices so only the image appears. -->
            <span class="hidden-xs">{{ Auth::user()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- The user image in the menu -->
            <li class="user-header">
              <img src="{{ URL::to('/') . '/' . Auth::user()->avatar_url}}" class="img-circle" alt="User Image">

              <p>
                  {{ Auth::user()->name }}
                <small>Thành viên từ {{ Carbon\Carbon::parse(Auth::user()->created_at)->format(config('app.format_date')) }}</small>
              </p>
            </li>            
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{ route('profile') }}" class="btn btn-default btn-flat">Thông tin</a>
              </div>
              <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">Đăng xuất</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar">
            <i class="fa fa-gears"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>