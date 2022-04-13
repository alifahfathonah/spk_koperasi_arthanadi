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
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="{{$idDatatables}}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>ID</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Alamat</th>
                <th>No Telp</th>
                <th>Kelas</th>
                <th>Agama</th>
                <th>JK</th>
                <th>Tanggal Lahir</th>
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
            size : 'modal-md',
            title : "<?= @$headerModalTambah ?>",
          }
          ajax_modal.show(_prop);											
        });  
      },
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
                              data: "id_pembayaran", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "nis", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "nama_siswa", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "alamat", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "no_telp", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "kelas", 
                              render: function ( val, type, row ){
                                  return row.jurusan+val
                                }
                        },
                        { 
                              data: "agama", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "jenis_kelamin", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "tanggal_lahir", 
                              render: function ( val, type, row ){
                                  return moment(val).format('DD/MM/YYYY')
                                }
                        },
                        { 
                              data: "id_pembayaran",
                              className: "text-center",
                              width: '150px',
                              render: function ( val, type, row ){
                                  var buttons = '<div class="btn-group" role="group">';
                                    buttons += '<a class=\"btn btn-warning btn-xs modalEdit\"><i class=\"fa fa-plus-circle\"></i> Setoran</a>';
                                    buttons += '<a href=\"{{ url('pembayaran-spp/proses-setoran') }}/'+ val +' \" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-american-sign-language-interpreting\"></i> Transaksi</a>';
                                    buttons += "</div>";
                                  return buttons
                                }
                            },
                    ],
                    createdRow: function ( row, data, index ){		
                      $( row ).on( "click", ".modalEdit",  function(e){
                          e.preventDefault();
                          var id = data.id_pembayaran;
                          var _prop= {
                              _this : $( this ),
                              remote : "{{ url("$nameroutes") }}/setoran/" + id,
                              size : 'modal-md',
                              title : "Setoran Pembayaran",
                          }
                          ajax_modal.show(_prop);											
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

