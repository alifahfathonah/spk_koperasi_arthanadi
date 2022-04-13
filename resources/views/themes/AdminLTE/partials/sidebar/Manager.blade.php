<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('themes/AdminLTE-2.4.3/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ get_user()->nama }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
          <li class="{{ Request::is('dashboard') ? 'active':null}}"><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
          <li class="treeview {{ Request::is('laporan/pembayaran') ? 'active':null}} {{ Request::is('laporan/rekapitulasi') ? 'active':null}} 
            {{ Request::is('laporan/rkas') ? 'active':null}} {{ Request::is('laporan/tunggakan') ? 'active':null}} 
            {{ Request::is('laporan/pembayaran-gedung') ? 'active':null}} {{ Request::is('laporan/tunggakan-gedung') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-clipboard" aria-hidden="true"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('laporan/pembayaran') ? 'active':null}}"><a href="{{ url('laporan/pembayaran') }}"><i class="fa fa-file-text-o"></i> Pembayaran</a></li>
              <li class="{{ Request::is('laporan/rekapitulasi') ? 'active':null}}"><a href="{{ url('laporan/rekapitulasi') }}"><i class="fa fa-file-text-o"></i> Rekapitulasi</a></li>
              <li class="{{ Request::is('laporan/tunggakan') ? 'active':null}}"><a href="{{ url('laporan/tunggakan') }}"><i class="fa fa-file-text-o"></i> Tunggakan</a></li>
              <li class="{{ Request::is('laporan/rkas') ? 'active':null}}"><a href="{{ url('laporan/rkas') }}"><i class="fa fa-file-text-o"></i> RKAS</a></li>
              <li class="{{ Request::is('laporan/tunggakan-spp') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-spp') }}"><i class="fa fa-file-text-o"></i> Pengeluaran Kas</a></li>
              <li class="{{ Request::is('laporan/pembayaran-gedung') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-gedung') }}"><i class="fa fa-file-text-o"></i> Pertanggung Jawaban</a></li>
              <li class="{{ Request::is('laporan/tunggakan-gedung') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-gedung') }}"><i class="fa fa-file-text-o"></i> Arus Kas</a></li>
              <li class="{{ Request::is('laporan/tunggakan-gedung') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-gedung') }}"><i class="fa fa-file-text-o"></i> Perubahan Modal</a></li>
              <li class="{{ Request::is('laporan/tunggakan-gedung') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-gedung') }}"><i class="fa fa-file-text-o"></i> Neraca</a></li>
            </ul>
          </li>
       
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>