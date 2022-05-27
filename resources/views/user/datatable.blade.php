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
        <table class="table table-striped table-bordered table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>ID Pengguna</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
                <th>Jabatan</th>
                <th class="no-sort">Aksi</th>
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
                                data: "id_pengguna", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_pengguna", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "username", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "password", 
                                render: function ( val, type, row ){
                                    return '********************'
                                  }
                          },
                          { 
                                data: "jabatan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "id",
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-info btn-xs modalEdit\"><i class=\"fa fa-pencil\"></i> {{ __('global.label_edit') }}</a>';
                                      buttons += '<a class=\"btn btn-success btn-xs modalDetail\"><i class=\"fa fa-file-text-o\"></i> {{ __('global.label_detail') }}</a>';
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
                              $.get("{{ url('user/delete') }}/" + data.id, function(response, status, xhr) {
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

                        $( row ).on( "click", ".modalDetail",  function(e){
                            e.preventDefault();
                            var id = data.id;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/view/" + id,
                                size : 'modal-md',
                                title : "<?= @$headerModalDetail ?>",
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
 
