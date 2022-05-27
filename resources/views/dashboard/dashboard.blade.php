@extends('themes.AdminLTE.layouts.template')
@section('content')
<div class="row">
  <section class="col-lg-12 connectedSortable">
    <!-- BAR CHART -->
    <div class="box box-success">
      <div class="box-body">
            <section class="content-header">
              <h1 align="center" style="font-size: 30px">
                <strong>{{ config('app.app_name') }}</strong>
              </h1>
            </section>
      </div>
      <!-- /.box-body -->
    </div>
  </section>
  </div>
<!-- /.row -->
       <div class="row">
        <section class="col-lg-12 connectedSortable">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Grafik Perangkingan</h3>
            </div>
            <div class="box-body chart-responsive">
              <div class="graph">
                <div class="chart" id="bar-chart" style="height:230px">
                 
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
 /*
     * BAR CHART
     * ---------
     */
  $(function () {
     var bar_data = {
      data : <?php echo json_encode(@$data_chart) ?>,
      // [
      //   ['A1', 80.4], ['A2', 30]
      // ],
      color: '#3c8dbc'
    }
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 0.2,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      
      series: {
        bars: {
          show    : true,
          barWidth: 0.2,
          align   : 'center'
        }
      },
      xaxis : {
        mode      : 'categories',
        tickLength: 0
      }
    });

  });
    /* END BAR CHART */

    // $(function () {
    //   $.fn.extend({
    //     functionGraph: { 
    //       init:function(){
    //             var post_data = {};
    //                 post_data.header = {
    //                   'year':$('#select_year').val()
    //                 }
    //             $.post( "{{url('dashboard/chart')}}", post_data, function( response, status, xhr ){
    //                 if ( response.status == 'error')
    //                 {
    //                   return false;
    //                 }
    //                 $.fn.functionGraph.chart(response.data);    
    //               });												
    //           $('#select_year').on( "change",  function(e){
    //             $('#bar-chart').remove();
    //             var post_data = {};
    //                 post_data.header = {
    //                   'year':$('#select_year').val()
    //                 }
    //             $.post( "{{url('dashboard/chart')}}", post_data, function( response, status, xhr ){
    //                 if ( response.status == 'error')
    //                 {
    //                   return false;
    //                 }

    //                 $( ".graph" ).append( " <div class=\"chart\" id=\"bar-chart\"></div>" );
    //                 $.fn.functionGraph.chart(response.data);    
    //               });												
    //           });
    //       },
    //     chart: function(data)
    //         {
    //           var bar = new Morris.Bar({
    //               barSizeRatio:0.2,
    //               element: 'bar-chart',
    //               resize: true,
    //               data: data,
    //               barColors: ['#00a65a', '#dd4b39'],
    //               xkey: 'Bulan',
    //               ykeys: ['Pemasukan', 'Pengeluaran'],
    //               labels: ['Pemasukan', 'Pengeluaran'],
    //               hideHover: 'auto',
    //               xLabelAngle: 10,
    //           });

    //         },
    //       }
    //   });

    //   $(document).ready(function(){
    //     $.fn.functionGraph.init();
    //   })
    // }); 
    </script>

    @endsection