@extends('themes.AdminLTE.layouts.template')
@section('content')
<br><br>
<div class="row">
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-aqua">
        <div class="inner">
          <h3 style="font-size: 25px">Rp. {{ number_format(@$pemasukan_hari_ini->total, 2) }}</h3>

          <p>Pemasukan Hari Ini</p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart fa-xs"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3 style="font-size: 25px">Rp. {{ number_format(@$pemasukan_bulan_ini->total, 2) }}</h3>

          <p>Pemasukan Bulan Ini</p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3 style="font-size: 25px">Rp. {{ number_format(@$pemasukan_tahun_ini->total, 2) }}</h3>

          <p>Pemasukan Tahun Ini</p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3 style="font-size: 25px">Rp. {{ number_format(@$pemasukan_total->total, 2) }}</h3>

          <p>Seluruh Pemasukan</p>
        </div>
        <div class="icon">
          <i class="fa fa-bar-chart"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
      </div>
    </div>
  <!-- /.col -->
</div>
<!-- /.row -->
       <div class="row">
        <section class="col-lg-12 connectedSortable">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
            </div>
            <div class="box-body chart-responsive">
              <div class="graph">
                <div class="chart" id="" style="height:230px">
                  <section class="content-header">
                    <h1 align="center" style="font-size: 50px">
                      <strong>{{ config('app.app_name') }}</strong>
                    </h1>
                  </section>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
        </div>
        <!-- /.box -->
        </section>
      </div>
      <!-- /.col -->
    <!-- /.row -->
    <script>
    let lookup = {
      lookup_modal_create: function() {
          $('#modalSiswa').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url('dashboard') }}/info_siswa",
              size : 'modal-lg',
              title : "<?= 'Informasi Siswa' ?>",
            }
            ajax_modal.show(_prop);											
          });  
        },
        lookup_modal_pemasukan: function() {
          $('#modalPemasukan').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url('dashboard') }}/info_pemasukan",
              size : 'modal-lg',
              title : "<?= 'Informasi Pemasukan' ?>",
            }
            ajax_modal.show(_prop);											
          });  
        },
        lookup_modal_pengeluaran: function() {
          $('#modalPengeluaran').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url('dashboard') }}/info_pengeluaran",
              size : 'modal-lg',
              title : "<?= 'Informasi Pengeluaran' ?>",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };

    $(function () {
      $.fn.extend({
        functionGraph: { 
          init:function(){
                var post_data = {};
                    post_data.header = {
                      'year':$('#select_year').val()
                    }
                $.post( "{{url('dashboard/chart')}}", post_data, function( response, status, xhr ){
                    if ( response.status == 'error')
                    {
                      return false;
                    }
                    $.fn.functionGraph.chart(response.data);    
                  });												
              $('#select_year').on( "change",  function(e){
                $('#bar-chart').remove();
                var post_data = {};
                    post_data.header = {
                      'year':$('#select_year').val()
                    }
                $.post( "{{url('dashboard/chart')}}", post_data, function( response, status, xhr ){
                    if ( response.status == 'error')
                    {
                      return false;
                    }

                    $( ".graph" ).append( " <div class=\"chart\" id=\"bar-chart\"></div>" );
                    $.fn.functionGraph.chart(response.data);    
                  });												
              });
          },
        chart: function(data)
            {
              var bar = new Morris.Bar({
                  barSizeRatio:0.2,
                  element: 'bar-chart',
                  resize: true,
                  data: data,
                  barColors: ['#00a65a', '#dd4b39'],
                  xkey: 'Bulan',
                  ykeys: ['Pemasukan', 'Pengeluaran'],
                  labels: ['Pemasukan', 'Pengeluaran'],
                  hideHover: 'auto',
                  xLabelAngle: 10,
              });

            },
          }
      });

      $(document).ready(function(){
        $.fn.functionGraph.init();
        lookup.lookup_modal_create();
        lookup.lookup_modal_pemasukan();
        lookup.lookup_modal_pengeluaran();
      })
    }); 
    </script>

    @endsection