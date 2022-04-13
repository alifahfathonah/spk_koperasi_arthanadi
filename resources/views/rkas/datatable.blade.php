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
      <div class="box-header">
        <h3 class="box-title">{{ @$title }}</h3>
        <div class="box-tools pull-right">
          {{-- <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-print"></i> Cetak RKAS</button> --}}
          <button type="button" class="btn btn-success btn-sm" id="modalCreate"><i class="fa fa-plus"></i> Tambah</button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>ID RKAS</th>
                <th>Tanggal</th>
                <th>Uraian Kegiatan</th>
                <th>Tahun Ajaran</th>
                <th>Sumber Dana</th>
                <th>Semester</th>
                <th>Jumlah</th>
                <th class="no-sort"> Aksi</th>
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
              title : "Tambah Data RKAS",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };
    let _datatables_show = {
      dt_rkas:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({									
							ajax: "{{ url($urlDatatables) }}",
              columns: [
                          {
                              data: "id",
                              className: "text-center",
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
                              }
                          },
                          { 
                                data: "id_rkas", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD MMMM YYYY')
                                  }
                          },
                          { 
                                data: "keterangan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tahun_ajaran", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "sumber_dana", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "semester", 
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
                          { 
                                data: "id",
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-info btn-xs modalEdit\"><i class=\"fa fa-pencil\"></i> Ubah</a>';
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
                                size : 'modal-md',
                                title : "Ubah Data RKAS",
                            }
                            ajax_modal.show(_prop);											
                        })

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt_rkas();
    lookup.lookup_modal_create();
});
</script>
@endsection
 
