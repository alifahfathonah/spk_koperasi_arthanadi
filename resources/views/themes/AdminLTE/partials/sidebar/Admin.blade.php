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
          <p>{{ @get_user()->nama_pengguna }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
          {{-- <li class="{{ Request::is('dashboard') ? 'active':null}}"><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li> --}}
          <li class="{{ Request::is('user') ? 'active':null}}"><a href="{{ url('user') }}"><i class="fa fa-user-plus"></i> <span>Data Pengguna</span></a></li>
          <li class="{{ Request::is('nasabah') ? 'active':null}}"><a href="{{ url('nasabah') }}"><i class="fa fa-users" aria-hidden="true"></i> <span>Data Nasabah</span></a></li>
          <li class="treeview {{ Request::is('group-kriteria') ? 'active':null}} {{ Request::is('kriteria') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-clipboard" aria-hidden="true"></i>
              <span>Data Kriteria</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('group-kriteria') ? 'active':null}}"><a href="{{ url('group-kriteria') }}"><i class="fa fa-file-text-o"></i> Group Kriteria</a></li>
              <li class="{{ Request::is('kriteria') ? 'active':null}}"><a href="{{ url('kriteria') }}"><i class="fa fa-file-text-o"></i> Kriteria</a></li>
            </ul>
          </li>
            <li class="{{ Request::is('alternatif') ? 'active':null}}"><a href="{{ url('alternatif') }}"><i class="fa fa-book" aria-hidden="true"></i> <span>Data Alternatif</span></a></li>
            <li class="{{ Request::is('pengajuan') ? 'active':null}}"><a href="{{ url('pengajuan') }}"><i class="fa fa-book" aria-hidden="true"></i> <span>Data Pengajuan</span></a></li>
            <li class="{{ Request::is('proses-spk') ? 'active':null}}"><a href="{{ url('proses-spk') }}"><i class="fa fa-clipboard"></i> Proses Hitung SPK</a></li>
            <li class="{{ Request::is('proses-spk/fucom-smart') ? 'active':null}}"><a href="{{ url('proses-spk/fucom-smart') }}"><i class="fa fa-files-o"></i> Hasil Perhitungan</a></li>
            <?php /* <li class="treeview {{ Request::is('proses-spk') ? 'active':null}} {{ Request::is('') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-clipboard" aria-hidden="true"></i>
              <span>Proses Hitung SPK</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('proses-spk') ? 'active':null}}"><a href="{{ url('proses-spk') }}"><i class="fa fa-file-text-o"></i> Data Kriteria</a></li>
              <li class="{{ Request::is('') ? 'active':null}}"><a href="#"><i class="fa fa-file-text-o"></i> Data Alternatif</a></li>
            </ul>
          </li> */ ?>
          {{-- <li class="{{ Request::is('jurnal') ? 'active':null}}"><a href="{{ url('jurnal') }}"><i class="fa fa-book" aria-hidden="true"></i> <span>Jurnal</span></a></li> --}}
          <?php /* <li class="treeview {{ Request::is('laporan/pembayaran') ? 'active':null}} {{ Request::is('laporan/rekapitulasi') ? 'active':null}} 
            {{ Request::is('laporan/rkas') ? 'active':null}} {{ Request::is('laporan/tunggakan') ? 'active':null}} 
            {{ Request::is('laporan/pengeluaran') ? 'active':null}} {{ Request::is('laporan/lpj') ? 'active':null}} 
            {{ Request::is('laporan/perubahan-modal') ? 'active':null}}
            {{ Request::is('laporan/neraca') ? 'active':null}}">
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
              <li class="{{ Request::is('laporan/rkas') ? 'active':null}}"><a href="{{ url('laporan/rkas') }}"><i class="fa fa-file-text-o"></i> RKAS</a></li> --}}
              <li class="{{ Request::is('laporan/pengeluaran') ? 'active':null}}"><a href="{{ url('laporan/pengeluaran') }}"><i class="fa fa-file-text-o"></i> Pengeluaran Kas</a></li>
              <li class="{{ Request::is('laporan/lpj') ? 'active':null}}"><a href="{{ url('laporan/lpj') }}"><i class="fa fa-file-text-o"></i> Pertanggung Jawaban</a></li>
              <li class="{{ Request::is('laporan/arus-kas') ? 'active':null}}"><a href="{{ url('laporan/arus-kas') }}"><i class="fa fa-file-text-o"></i> Arus Kas</a></li>
              <li class="{{ Request::is('laporan/perubahan-modal') ? 'active':null}}"><a href="{{ url('laporan/perubahan-modal') }}"><i class="fa fa-file-text-o"></i> Perubahan Anggaran</a></li>
              <li class="{{ Request::is('laporan/neraca') ? 'active':null}}"><a href="{{ url('laporan/neraca') }}"><i class="fa fa-file-text-o"></i> Neraca</a></li> --}}
            </ul>
          </li> */ ?>
        </ul>
    </section>
  </aside>