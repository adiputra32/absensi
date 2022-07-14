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
      <li class="{{ (request()->is('admin/dashboard')) ? ' active' : '' }}"><a class="nav-link" href="/admin/dashboard"><i class="fa fa-columns"></i> <span>Dashboard</span></a></li>
      <li class="menu-header">Absensi</li>
      <!-- <li class="{{ (request()->is('admin/absensi-kegiatan')) ? ' active' : '' }}"><a class="nav-link" href="/admin/absensi-kegiatan"><i class="fa fa-users"></i> <span>Absensi Kegiatan</span></a></li> -->
      <li class="{{ (request()->is('admin/absensi-kelas')) ? ' active' : '' }}"><a class="nav-link" href="/admin/absensi-kelas"><i class="fa fa-users"></i> <span>Absensi Kelas</span></a></li>
      <li class="menu-header">Data Akademik</li>
      <li class="{{ (request()->is('admin/tahun-akademik')) ? ' active' : '' }}"><a class="nav-link" href="/admin/tahun-akademik"><i class="fa fa-calendar-alt"></i> <span>Tahun Akademik</span></a></li>
      <li class="{{ (request()->is('admin/prodi')) ? ' active' : '' }}"><a class="nav-link" href="/admin/prodi"><i class="fa fa-university"></i> <span>Data Program Studi</span></a></li>
      <li class="{{ (request()->is('admin/mata-kuliah')) ? ' active' : '' }}"><a class="nav-link" href="/admin/mata-kuliah"><i class="fa fa-book"></i> <span>Data Mata Kuliah</span></a></li>
      <li class="{{ (request()->is('admin/kelas')) ? ' active' : '' }}"><a class="nav-link" href="/admin/kelas"><i class="fa fa-chalkboard"></i> <span>Data Kelas</span></a></li>
      <li class="menu-header">User</li>
      <li class="{{ (request()->is('admin/staff')) ? ' active' : '' }}"><a class="nav-link" href="/admin/staff"><i class="fa fa-users"></i> <span>Data Staff</span></a></li>
      <li class="{{ (request()->is('admin/dosen')) ? ' active' : '' }}"><a class="nav-link" href="/admin/dosen"><i class="fa fa-users"></i> <span>Data Dosen</span></a></li>
      <li class="{{ (request()->is('admin/mahasiswa')) ? ' active' : '' }}"><a class="nav-link" href="/admin/mahasiswa"><i class="fa fa-users"></i> <span>Data Mahasiswa</span></a></li>

    </ul>
</aside>
