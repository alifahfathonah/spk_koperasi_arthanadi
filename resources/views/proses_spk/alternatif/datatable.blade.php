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
              <button class="btn btn-success btn-sm" id="modalCreate">{{ "Proses SPK" }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
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
                <th>Alternatif</th>
                <th>C1</th>
                <th>C2</th>
                <th>C3</th>
                <th>C4</th>
                <th>C5</th>
                <th>C6</th>
                <th>C7</th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
      </div>
    </div>

<!-- DataTable -->
<script type="text/javascript">
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
                              data: "kode_alternatif", 
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
                              data: "C3", 
                              render: function ( val, type, row ){
                                  return val
                              }
                          },
                          { 
                              data: "C4", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "C5", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "C6", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "C7", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          }
                      ],
                      createdRow: function ( row, data, index ){		
       

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
});
</script>
@endsection
 
