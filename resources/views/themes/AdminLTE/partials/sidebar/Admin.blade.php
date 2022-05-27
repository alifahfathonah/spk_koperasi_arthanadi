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
          <li class="{{ Request::is('dashboard') ? 'active':null}}"><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
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
              <li class="{{ Request::is('group-kriteria') ? 'active':null}}"><a href="{{ url('group-kriteria') }}"><i class="fa fa-circle-o-notch"></i> Kriteria</a></li>
              <li class="{{ Request::is('kriteria') ? 'active':null}}"><a href="{{ url('kriteria') }}"><i class="fa fa-circle-o-notch"></i> Bobot Kriteria</a></li>
            </ul>
          </li>
            <li class="{{ Request::is('alternatif') ? 'active':null}}"><a href="{{ url('alternatif') }}"><i class="fa fa-id-card" aria-hidden="true"></i> <span>Data Pengajuan</span></a></li>
            <li class="{{ Request::is('pengajuan') ? 'active':null}}"><a href="{{ url('pengajuan') }}"><i class="fa fa-balance-scale" aria-hidden="true"></i> <span>Data Alternatif</span></a></li>
            <li class="treeview {{ Request::is('proses-spk') ? 'active':null}} {{ Request::is('proses-spk/fucom-smart') ? 'active':null}} {{ Request::is('proses-spk/perangkingan') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-handshake-o" aria-hidden="true"></i>
              <span>Proses Hitung SPK</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('proses-spk') ? 'active':null}}"><a href="{{ url('proses-spk') }}"><i class="fa fa-circle-o-notch"></i> Proses Perhitungan</a></li>
              <li class="{{ Request::is('proses-spk/fucom-smart') ? 'active':null}}"><a href="{{ url('proses-spk/fucom-smart') }}"><i class="fa fa-circle-o-notch"></i> Hasil Perhitungan</a></li>
              <li class=""><a href="javascript:void(0)" id="reset_hasil"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> <span>Hapus Hasil Perhitungan</span></a></li>
            </ul>
          </li>
          <li class="treeview {{ Request::is('laporan/pengajuan') ? 'active':null}} {{ Request::is('laporan/hasil-perhitungan') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-clipboard" aria-hidden="true"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('laporan/pengajuan') ? 'active':null}}"><a href="{{ url('laporan/pengajuan') }}"><i class="fa fa-file-text-o"></i> Pengajuan</a></li>
              <li class="{{ Request::is('laporan/hasil-perhitungan') ? 'active':null}}"><a href="{{ url('laporan/hasil-perhitungan') }}"><i class="fa fa-file-text-o"></i> Hasil Alternatif Keputusan</a></li>
            </ul>
          </li>
        </ul>
    </section>
  </aside>

  <script>
    $('#reset_hasil').on('click',function(e) {
    e.preventDefault();
    if(!confirm("Data hasil perhitungan sebelumnya akan dihapus, apakah anda yakin?")) {
      return false;
    }

    $.get("{{ url('proses-spk/reset-hasil') }}", function(response, status, xhr) {
        if( response.status == "error"){
            $.alert_warning(response.message);
                return false
            }
            $.alert_success(response.message);
            setTimeout(function(){
              location.reload();   
            }, 500);  
        }).catch(error => {
              $.alert_error(error);
              return false
        });
  });
  </script>