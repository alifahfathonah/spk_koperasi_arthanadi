@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ @$title }}</h3>
        <div class="box-tools pull-right">
            <div class="btn-group">
              <button class="btn btn-success btn-sm" id="modalCreate"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
            </div>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="table-responsive">
        <div class="box-body">
          <table class="table table-striped table-bordered table-hover" id="{{ $idDatatables }}" width="100%">   
              <thead>
                <tr>
                  <th class="no-sort">No</th>
                  <th>ID Alternatif</th>
                  <th>Tanggal Alternatif</th>
                  <th>Kode</th>
                  <th>Nama Nasabah</th>
                  <th>Jaminan</th>
                  <th>Karakter</th>
                  <th>Kemampuan</th>
                  <th>Pendapatan</th>
                  <th>Pengeluaran</th>
                  <th>Kondisi Hutang</th>
                  <th>Status Proses</th>
                  <th class="no-sort">Aksi</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
            </table>
        </div>
      </div>
    </div>

<!-- DataTable -->
<script type="text/javascript">
    let lookup = {
      lookup_modal_create: function() {
          $('#modalCreate').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url("$nameroutes") }}/create",
              size : 'modal-lg',
              title : "<?= @$headerModalTambah ?>",
            }
            ajax_modal.show(_prop);											
          });  
        }
    };
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({									
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){

									}
								},
              columns: [
                          {
                              data: "id",
                              className: "text-center",
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
                              }
                          },
                          { 
                              data: "id_pengajuan", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "tgl_pengajuan", 
                              render: function ( val, type, row ){
                                  return moment(val).format('DD/MM/YYYY')
                              }
                          },
                          { 
                              data: "kode_alternatif", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "nama_nasabah", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                                data: "C1", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "C2", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "kemampuan", 
                                render: function ( val, type, row ){
                                    return val + ' Tahun'
                                  }
                          },
                          { 
                                data: "pendapatan", 
                                render: function ( val, type, row ){
                                    return val + ' Juta'
                                  }
                          },
                          { 
                                data: "pengeluaran", 
                                render: function ( val, type, row ){
                                    return val + ' Juta'
                                  }
                          },
                          { 
                                data: "C6", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                              data: "sudah_proses", 
                              render: function ( val, type, row ){
                                  if(val == 1){
                                    var label = '<label class="label label-success">Sudah Proses</label>'
                                  }else{
                                    var label = '<label class="label label-warning">Belum Proses</label>'
                                  }
                                  return label
                              }
                          },
                          { 
                                data: "id",
                                className: "text-center",
                                width: '160px',
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-info btn-xs modalEdit\"><i class=\"fa fa-pencil\"></i> {{ __('global.label_edit') }}</a>';
                                      buttons += '<a class=\"btn btn-danger btn-xs modalHapus\"><i class=\"fa fa-trash\"></i> Hapus</a>';
                                      buttons += "</div>";
                                    return buttons
                                }
                              },
                      ],
                      createdRow: function ( row, data, index ){		
                        $( row ).on( "click", ".modalEdit",  function(e){
                            e.preventDefault();
                            var id = data.id;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/edit/" + id,
                                size : 'modal-lg',
                                title : "<?= @$headerModalEdit ?>",
                            }
                            ajax_modal.show(_prop);											
                        })

                        $( row ).on( "click", ".modalHapus",  function(e){
                            e.preventDefault();
                            if( confirm( "Apakah anda yakin menghapus data ini?" ) ){
                              $.get("{{ url('pengajuan/delete') }}/" + data.id, function(response, status, xhr) {
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
                            }										
                        })


                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
    lookup.lookup_modal_create();
});
</script>
@endsection
 
