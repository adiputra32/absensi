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
      <li class="{{ (request()->is('dosen-koordinator/dashboard')) ? ' active' : '' }}"><a class="nav-link" href="/dosen-koordinator/dashboard"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
      <li class="menu-header">Absensi Kegiatan</li>
      <li class="{{ (request()->is('dosen-koordinator/absensi-kegiatan')) ? ' active' : '' }}"><a class="nav-link" href="/dosen-koordinator/absensi-kegiatan"><i class="fa fa-users"></i> <span>Absensi Kegiatan</span></a></li>
    </ul>
</aside>
