@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li><a href="{{ url(@$nameroutes) }}">{{ @$breadcrumb }}</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ @$title }}</h3>
      <div class="box-tools pull-right">
          <div class="btn-group">
            <a href="{{ url(@$nameroutes) }}/create" class="btn btn-success btn-sm" title="Tambah Data"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('global.label_create') }}</a>
          </div>

        </button>
      </div>
    </div>
      <!-- /.box-header -->
<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" id="form_crud">
  {{ csrf_field() }}
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
          <label class="col-lg-3 control-label">No Bukti *</label>
          <div class="col-lg-9">
            <input type="text"  class="form-control" name="f[id_pengeluaran]" id="id_pengeluaran" value="{{ @$item->id_pengeluaran }}"  required="" readonly>
          </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Tanggal *</label>
        <div class="col-lg-9">
          <input type="date" name="f[tanggal]" id="tanggal" class="form-control" placeholder="Tanggal" value="{{ date('Y-m-d', strtotime(@$item->tanggal)) }}" required="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Total *</label>
        <div class="col-lg-9">
          <input type="text" name="total" id="total" class="form-control mask-number" placeholder="Total" value="{{ @$item->total }}" required="" readonly>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-lg-3 control-label">Akun Kas *</label>
        <div class="col-lg-9">
          <div class="input-group data_collect_wrapper">
            <input type="hidden" id="akun_id" name="f[akun_id]" required value="{{ @$item->akun_id }}">
            <input type="text" name="f[nama_akun]" id="nama_akun" value="{{ @$item->nama_akun }}" class="form-control" placeholder="Akun Kas" required="" readonly>
            <div class="input-group-btn">
              <a href="javascript:;" id="lookup_akun" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Upload Nota</label>
        @if(@$is_edit)
          <div class="col-lg-9">
            <h5>{{ @$item->bukti_struk }}   <a href="{{ url("themes/default/images/bukti_struk/{$item->bukti_struk}") }}" target="_blank" class="btn btn-warning btn-xs">Lihat</a></h5> 
          </div>
        @else
          <div class="col-lg-9">
            <input type="hidden" id="image_name" class="form-control" value="{{ @$item->bukti_struk }}" name="f[bukti_struk]">
            <input type="file" id="input-file" name="bukti_struk" class="">
          </div>
        @endif
      </div>
    </div>
        {{-- tabel --}}
        <table class="table table-striped table-hover" id="dt_detail" width="100%">   
          <thead>
            <tr>
              <th></th>
              <th>Keterangan</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
        <div>
            <a  title="Tambah" id="lookup_detail" class="btn btn-block btn-github"><i class="fa fa-plus" aria-hidden="true"></i> <b>Tambah Detail</b> </a>
        </div>
  </div>
  <div class="box-footer">
    @if(@$item->status_batal == 1)
      <div class="pull-center">
        <h4 style="color: red;text-align:center">Data ini sudah dibatalkan!</h4>
      </div>
    @endif
    <div class="pull-right">
          @if(@$is_edit)
            <button title="Batalkan data" @if(@$item->status_batal == 1) disabled @else id="cancel" @endif  class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Batalkan</button>
          @else
            <button id="submit_form" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> {{ __('global.label_save') }} </button> 
          @endif
    </div>
  </div>
</form>

<script type="text/javascript">
      $(document).on('change','#input-file',function(){
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          $('.tombolform').prop("disabled", true);
        $.ajax({
          url:"{{ url('pengeluaran/upload-nota') }}",
          data:new FormData($("#form_crud")[0]),
          dataType:'json',
          async:false,
          method:'POST',
          processData: false,
          contentType: false,
          success:function(response, status, xhr){
            if( response.status == "error"){
							swal({
                icon: 'error',
                title: 'Oops...',
                text: response.message,
              });
              $('#submit_form').prop("disabled", false);
							return false
						}
					
              $('#image_name').val(response.filename) 
              $('#submit_form').prop("disabled", false);
          },
        });
      });


      let lookup = {
        lookup_modal_detail: function() {
            $('#lookup_detail').on( "click", function(e){
              e.preventDefault();
              var collections = {
                    "keterangan": '',
                    "nominal" : mask_number.currency_add(0),
                };
   
                $("#dt_detail").DataTable().row.add( collections ).draw();
            });  
          },
      };
      var _datatable_actions = {
          edit: function( row, data, index ){
												
                     switch( this.index() ){				
                          case 1:
                          
                            var _input = $( "<input type=\"text\" value=\"" + (data.keterangan) + "\" style=\"width:100%\"  class=\"form-control\">" );
                            this.empty().append( _input );
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.keterangan = this.value != '' ? this.value : data.keterangan;
										              _datatable.row( row ).data( data );
                                  
                                } catch(ex){}
                              });
                          break;			

                          case 2:
                          
                            var _input = $( "<input type=\"text\" value=\"" + Number(data.nominal || 1) + "\" style=\"width:100%\"  class=\"form-control mask-number\" min=\"1\">" );
                            var total;
                            this.empty().append( _input );
                            
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.nominal = this.value;
                                    _datatable.row( row ).data( data );
                                    _datatable_actions.calculate_sum()
                                  
                                } catch(ex){}
                              });
                          break;
            
                          
            
                        }
                        
                    },
            calculate_sum: function(params, fn, scope){
                var grandtotal = 0;
                
                var collection = $( "#dt_detail" ).DataTable().rows().data();
                
                collection.each(function(value, index){
                  
                  grandtotal += Number(mask_number.currency_remove( value.nominal ));
                    
                });
                $("#total").val(mask_number.currency_add(grandtotal));	
              },
          remove: function( params, fn, scope ){
						_datatable.row( scope ).remove().draw(false);
          }
			};

  var _datatables_dt_detail = {
    dt_detail:function(){
          _datatable = $('#dt_detail').DataTable({
            processing: true,
            serverSide: false,								
            paginate: false,
            ordering: false,
            searching: false,
            info: false,
            destroy: true,
            responsive: false,								
            <?php if (!empty(@$collection)):?>
              data: <?php print_r(json_encode(@$collection, JSON_NUMERIC_CHECK));?>,
            <?php endif; ?>
            columns: [
                        {
                            data: "keterangan",
                            className: 'text-center',
                            render: function (val, type, row) {
                              return '<a title=\"Hapus\" class=\"btn btn-danger btn-remove\"><i class=\"fa fa-trash\"></i></a>';
                            }
                        },
                        { 
                              data: "keterangan", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "nominal", 
                              render: function ( val, type, row ){
                                  return mask_number.currency_add(val)
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
    $('#lookup_akun').dataCollect({
        ajaxUrl: "{{ url('akun/datatables-lookup-collection') }}",
        ajaxMethod: 'GET',
			  ajaxData: function(params){
            params.kelompok = 'Aktiva Lancar';
			  },
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN AKUN',
        modalTxtSelect : 'Pilih Akun',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['No Akun','Nama Akun','Kelompok'],
        dtColumns: [
            {data: "kode_akun"}, 
            {data: "nama_akun"}, 
            {data: "kelompok"}, 
        ],
        onSelected: function(data, _this){	
          $('#akun_id').val(data.id);
          $('#nama_akun').val(data.nama_akun); 
            
          return true;
        }
    });


    _datatables_dt_detail.dt_detail();
    lookup.lookup_modal_detail();

  });
  $("form#form_crud").on('submit',function(e) {
      e.preventDefault();
          var header_data = {
                    'tanggal' : $("#tanggal").val(),
                    'akun_id' :  $("#akun_id").val(),
                    'keterangan': $("#keterangan").val(),
                    'total': mask_number.currency_remove($("#total").val()),
                    'bukti_struk': $("#image_name").val()
                }

            var data_post = {
                    "details" : {},
                    "header" : header_data
                }
            
              _datatable.rows().data().each(function (value, index){
                    var details_form = {
                        'nominal' : mask_number.currency_remove(value.nominal),
                        'keterangan' : value.keterangan,
                        'akun_id' : value.akun_id || ''
                    }
                    data_post.details[index] = details_form;
                });
        
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
        if( response.status == "error"){
              $.alert_error( response.message );
							return false
						}
						
            $.alert_success( response.message );
            setTimeout(function(){
              document.location.href = "{{ url("$nameroutes") }}";  
            }, 500);  
    });
    return false;
});

$("#cancel").on('click',function(e) {
      e.preventDefault();
      if(!confirm('Apakah anda yakin membatalkan data ini?'))
      {
        return false
      }
      var header_data = {
                'tanggal' : $("#tanggal").val(),
                'id_pengeluaran' : $("#id_pengeluaran").val(),
                'akun_id' :  $("#akun_id").val(),
                'keterangan': $("#keterangan").val(),
                'total': mask_number.currency_remove($("#total").val()),
            }

      var data_post = {
              "header" : header_data
          }
            
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
        if( response.status == "error"){
              $.alert_error( response.message );
							return false
						}
						
            $.alert_success( response.message );
            setTimeout(function(){
              document.location.href = "{{ url("$nameroutes") }}";  
            }, 500);  
    });
    return false;
});


</script>
@endsection