<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{ URL::to('/') . '/' . Auth::user()->avatar_url}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{ Auth::user()->name }}</p>                    
        <p>{{ empty($roles->firstWhere('id', Auth::user()->role_id))?  'KXĐ' : $roles->firstWhere('id', Auth::user()->role_id)->description}}</p>
      </div>
    </div>      
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">CHỨC NĂNG</li>
        @include('layouts.menu')
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>