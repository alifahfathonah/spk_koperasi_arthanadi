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
              <a href="{{ url(@$nameroutes) }}/create" class="btn btn-success btn-sm" title="Tambah Data"><i class="fa fa-plus" aria-hidden="true"></i> {{ __('global.label_create') }}</a>
            </div>

          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="{{$idDatatables}}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>ID Pengeluaran</th>
                <th>Tanggal</th>
                <th>Akun</th>
                {{-- <th>Keterangan</th> --}}
                <th>Nominal</th>
                <th>Status</th>
                <th class="no-sort"><i class="fa fa-cog" aria-hidden="true"></i></th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
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
        },
    };

    var id_datatables = "{{ $idDatatables }}";

      _datatables_show = {
        dt_datatables:function(){
        var _this = $("#"+id_datatables);
            _datatable = _this.DataTable({									
							ajax: "{{ url("{$urlDatatables}") }}",
              columns: [
                          {
                              data: "id",
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
                              }
                          },
                          { 
                                data: "id_pengeluaran", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_akun", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          // { 
                          //       data: "keterangan", 
                          //       render: function ( val, type, row ){
                          //           return val
                          //         }
                          // },
                          { 
                                data: "total", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val)
                                  }
                          },
                          { 
                              data: "status_batal", 
                                render: function ( val, type, row ){
                                    var button_success = `<label class="label label-danger">Dibatalkan</label>`;
                                        button_danger  = `<label class="label label-success">Aktif</label>`;

                                        return (val == 1) ? button_success : button_danger
                                  }
                          },
                          { 
                                data: "id",
                                width: '230px',
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                    if(row.status_batal == 1){
                                      buttons += '<a class=\"btn btn-warning btn-xs modalRiwayat\"><i class=\"fa fa-eye\"></i> Riwayat Batal</a>';  
                                      buttons += '<a class=\"btn btn-danger btn-xs\" disabled><i class=\"fa fa-ban\"></i> Batal</a>';    
                                      buttons += '<a href=\"{{ url('pengeluaran/detail') }}/'+ val +'\" title=\"Lihat Data\" class="btn btn-info btn-xs"><i class=\"fa fa-eye\"></i> Lihat</a>';      
                                    }else{
                                      buttons += '<a class=\"btn btn-danger btn-xs modalCancel\"><i class=\"fa fa-ban\"></i> Batal</a>';  
                                      buttons += '<a href=\"{{ url('pengeluaran/detail') }}/'+ val +'\" title=\"Lihat Data\" class="btn btn-info btn-xs"><i class=\"fa fa-eye\"></i> Lihat</a>';      
                                    }
                                    buttons += "</div>";
                                    return buttons
                                  }
                              },
                      ],
                      createdRow: function ( row, data, index ){		
                        $( row ).on( "click", ".modalCancel",  function(e){
                            e.preventDefault();
                            var id = data.id;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/cancel/" + id,
                                size : 'modal-sm',
                                title : "Konfirmasi!",
                            }
                            ajax_modal.show(_prop);											
                        });
                        $( row ).on( "click", ".modalRiwayat",  function(e){
                            e.preventDefault();
                            var id = data.id;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/riwayat/" + id,
                                size : 'modal-sm',
                                title : "Riwayat Pembatalan",
                            }
                            ajax_modal.show(_prop);											
                        })

                      }
                                                  
                  });
							
                  return _this;
				}

			}
  
$(document).ready(function() {
  _datatables_show.dt_datatables();
  lookup.lookup_modal_create();
});
  </script>
@endsection
 
