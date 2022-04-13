@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li><a href="{{ url(@$nameroutes) }}">{{ 'Pembayaran SPP' }}</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
<form  method="POST" action="{{ url($submit_url) }}" class="" name="form_crud">
  {{ csrf_field() }}
  <div class="box">
        <!-- /.box-header -->
    <div class="box-body" id="proses0">
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleInputEmail1">NIS</label>
          <input type="text" class="form-control" name="f[nis]" id="nis" value="{{ @$item->nis }}" required="" readonly>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label for="exampleInputEmail1">Nama Siswa</label>
          <input type="text" class="form-control" name="f[nama]" id="nama_siswa" value="{{ @$item->nama_siswa }}" required="" readonly>
        </div>
      </div>
    </div>  
    <div class="box-body" id="proses1" style="display: none">
      <h1 style="text-align: center">Belum ada setoran tabungan!</h1>
    </div>  
  </div>
</form>
<div class="box">
  <div class="box-body">
    <div class="col-lg-12">
      <table class="table table-striped table-hover" id="dt_detail_pembayaran" width="100%">   
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Semester</th>
            <th>Bulan</th>
            <th>Nominal</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        
        </tbody>
      </table>
    </div>
  </div>

<script type="text/javascript">
      var _datatable_actions = {
          edit: function( row, data, index ){
												
                        switch( this.index() ){									
                          case 2:
                          
                            var _input = $( "<input type=\"text\" value=\"" + Number(data.nominal_bayar || 1) + "\" style=\"width:100%\"  class=\"form-control mask-number\" min=\"1\">" );
                            var total;
                            this.empty().append( _input );
                            
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.nominal_bayar = this.value;
                                    _datatable.row( row ).data( data );
                                    _datatable_actions.calculate_sum()
                                  
                                } catch(ex){}
                              });
                          break;
            
                          
            
                        }
                        
                      },
            calculate_sum: function(params, fn, scope){
                var grandtotal = 0;
                
                var collection = $( "#dt_detail_pembayaran" ).DataTable().rows().data();
                
                collection.each(function(value, index){
                  
                  grandtotal += Number(mask_number.currency_remove( value.nominal_bayar ));
                    
                });
                $("input[name='f[total]']").val(mask_number.currency_add(grandtotal));	
              },
          remove: function( params, fn, scope ){
            $.get("{{ url('pembayaran-spp/batal') }}/" + params.id, function(response, status, xhr) {
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
						// _datatable.row( scope ).remove().draw(false);
          }
			};

  var _datatables_detail_pembayaran = {
      dt_detail_pembayaran:function(){
          _datatable = $('#dt_detail_pembayaran').DataTable({
            processing: true,
            serverSide: false,								
            paginate: true,
            ordering: true,
            searching: true,
            info: true,
            destroy: true,
            order:[ 0, 'desc'],
            responsive: false,								
            <?php if (!empty(@$collection)):?>
              data: <?php print_r(json_encode(@$collection, JSON_NUMERIC_CHECK));?>,
            <?php endif; ?>
            columns: [
                        { 
                              data: "tgl_pembayaran", 
                              render: function ( val, type, row ){
                                  return moment(val).format("DD MMMM Y");  
                                }
                        },
                        { 
                              data: "semester", 
                              render: function ( val, type, row ){
                                return 'Semester ' + val
                                }
                        },
                        { 
                              data: "bulan", 
                              render: function ( val, type, row ){
                                  return moment().month(val - 1).format("MMMM");
                                }
                        },
                        { 
                              data: "nominal", 
                              render: function ( val, type, row ){
                                  return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                }
                        },
                        { 
                              data: "keterangan", 
                              render: function ( val, type, row ){
                                return val
                                }
                        },
                        { 
                              data: "batal", 
                                render: function ( val, type, row ){
                                    var button_danger = `<label class="label label-danger">Dibatalkan</label>`;
                                        button_success  = `<label class="label label-success">Aktif</label>`;

                                        return (val == 1) ? button_danger : button_success
                                  }
                          },
                        { 
                                data: "id",
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                        if(row.batal == 1)
                                        {
                                          buttons += '<a title=\"Batal\" class=\"btn btn-danger btn-xs\" disabled><i class=\"fa fa-ban\"></i> Batalkan</a>';
                                        }else{
                                          buttons += '<a href=\"{{ url('pembayaran-spp/batal') }}/'+ val +'\" title=\"Batal\" class=\"btn btn-danger btn-xs btn-remove\"><i class=\"fa fa-ban\"></i> Batalkan</a>';
                                        }


                                      if(row.proses == 1){
                                        if(row.batal == 1)
                                        {
                                          buttons += '<a target=\"\_blank" title=\"Cetak\" class=\"btn btn-warning btn-xs\" disabled><i class=\"fa fa-print\"></i> Cetak</a>';
                                        }else{
                                          buttons += '<a href=\"{{ url('pembayaran-spp/cetak') }}/'+ val +'\" target=\"\_blank" title=\"Cetak\" class=\"btn btn-warning btn-xs\"><i class=\"fa fa-print\"></i> Cetak</a>';
                                        }
                                      }else{ 
                                        buttons += '<a href=\"{{ url('pembayaran-spp/simpan-proses-setoran') }}/'+ val +'\" title=\"Cetak\" class=\"btn btn-success btn-xs\"><i class=\"fa fa-refresh\"></i> Proses</a>';
                                      }
                                        buttons += "</div>";
                                    return buttons
                                  }
                              },
                    ],
                    createdRow: function ( row, data, index ){		
                      _datatable_actions.calculate_sum();
                      $( row ).on( "dblclick", "td", function(e){
                          e.preventDefault();												
                          var elem = $( e.target );
                          _datatable_actions.edit.call( elem, row, data, index );
                        });
                      $( row ).on( "click", "a.btn-remove", function(e){
                          e.preventDefault();												
                          var elem = $( e.target );
                          
                          if( confirm( "Apakah anda yakin menghapus data ini?" ) ){
                            _datatable_actions.remove( data, null, row )
                            _datatable_actions.calculate_sum();
                          }
                      });
                  }
                                                
                });
            
      }

    }

	$( document ).ready(function(e) {
    _datatables_detail_pembayaran.dt_detail_pembayaran();
    if("<?= @$item->proses == 1 ?>"){
      $("#proses1").css("display", "");
      $("#proses0").css("display", "none");
    }
  });
  $(".btn-save").on('click',function(e) {
      e.preventDefault();
      if(!confirm('Apakah anda yakin memproses data ini?')){
        return false
      }
      $('.btn-save').addClass('disabled', true);
      $(".spinner").css("display", "");
          var header_data = {
                    'no_rek_tabungan' : $("#no_rek_tabungan").val(),
                    'kredit' : $("#kredit").val(),
                }

            var data_post = {
                    "f" : header_data
                }
        
    // var data_post = new FormData($(this)[0]);
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
      if( response.status == "error"){
          $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled');
              $(".spinner").css("display", "none");
              return false
          }
          $.alert_success(response.message);
              $('.btn-save').removeClass('disabled');
              $(".spinner").css("display", "none");
              ajax_modal.hide();
              setTimeout(function(){
                // location.reload();
                // document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
                $('.btn-save').removeClass('disabled');
                $(".spinner").css("display", "none");
                return false
      });
});

</script>
@endsection