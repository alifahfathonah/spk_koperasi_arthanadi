@extends('themes.AdminLTE.layouts.template')
@section('content')
<br><br>
  <div class="row">
    <a href="{{ url('pengeluaran') }}">
      <div class="col-lg-3 col-sm-offset-2">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3 align="center"><i class="fa fa-credit-card" aria-hidden="true"></i></h3>
            <p align="center">Pengeluaran</p>
          </div>
        </div>
      </div>
    </a>
      <!-- ./col -->
      <a href="{{ url('jurnal') }}">
        <div class="col-lg-3 col-sm-offset-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 align="center"><i class="fa fa-balance-scale" aria-hidden="true"></i></h3>
              <p align="center">Jurnal Umum</p>
            </div>
          </div>
        </div>
      </a>
  </div>
</section>
</div>
<style>
  .small-box>.inner {
      padding: 25px!important;
  }
</style>
@endsection