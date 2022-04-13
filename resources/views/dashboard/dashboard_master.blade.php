@extends('themes.AdminLTE.layouts.template')
@section('content')
<section class="content-header">
  <h1 align="center">
    <strong>{{ config('app.app_name') }}</strong>
  </h1>
</section>
<br><br>
<div class="row">
  <a href="{{ url('siswa') }}">
    <div class="col-lg-3 col-sm-offset-1">
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3 align="center"><i class="fa fa-users fa-lg" aria-hidden="true"></i></h3>

          <p align="center">Data User</p>
        </div>
        {{-- <div class="icon">
          <i class="ion ion-bag"></i>
        </div> --}}
        {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
      </div>
    </div>
  </a>
    <!-- ./col -->
    <a href="{{ url('siswa') }}">
      <div class="col-lg-3 col-sm-offset-1">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3 align="center"><i class="fa fa-user-secret fa-lg" aria-hidden="true"></i></h3>

            <p align="center">Data Siswa</p>
          </div>
          {{-- <div class="icon">
            <i class="ion ion-bag"></i>
          </div> --}}
          {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
    </a>
    <!-- ./col -->
    <a href="{{ url('akun') }}">
      <div class="col-lg-3 col-sm-offset-1">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3 align="center"><i class="fa fa-balance-scale fa-lg" aria-hidden="true"></i></h3>

            <p align="center">Data Akun</p>
          </div>
          {{-- <div class="icon">
            <i class="ion ion-bag"></i>
          </div> --}}
          {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
        </div>
      </div>
    </a>
  <!-- /.col -->
</div>
<!-- /.row -->
       {{-- <div class="row">
        <section class="col-lg-12 connectedSortable">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Data Keuangan Sekolah Per Tahun</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="col-md-2 pull-right">
                <select name="year" id="select_year" class="form-control">
                  <option value="2018">2016</option>
                  <option value="2019">2017</option>
                  <option value="2018">2018</option>
                  <option value="2019">2019</option>
                  <option value="2020">2020</option>
                  <option value="2021" selected>2021</option>
                </select>
              </div>

              <div class="graph">
                <div class="chart" id="bar-chart" style="height:230px"></div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </section>
        </div> --}}
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