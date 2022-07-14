<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="30" style="margin-left: -50px; margin-right: 10px;" class="shadow-light rounded-circle">
    <a href="#">ABSENSI</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
  <a href="#"><img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="30" class="shadow-light rounded-circle"></a>
  </div>
  <ul class="sidebar-menu">
      <li class="menu-header">Dashboard</li>
      <li class="{{ (request()->is('dashboard')) ? ' active' : '' }}"><a class="nav-link" href="/dashboard"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
    </ul>
</aside>
