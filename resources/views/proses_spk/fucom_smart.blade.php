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
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-6">
            <label class="col-md-1 control-label">Periode Awal</label>
            <div class="col-md-3">
              <input type="date" class="form-control" id="date_start" name="date_start" required value="{{ date('Y-m-d') }}">
            </div>
          </div>
          <div class="col-6">
            <label class="col-md-1 control-label">Periode Akhir</label>
            <div class="col-md-3">
              <input type="date" class="form-control" id="date_end" name="date_end" required value="{{ date('Y-m-d') }}">
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <div class="box-body">
          <table class="table table-striped table-bordered table-hover" id="dt_fucom_smart" width="100%">   
              <thead>
                <tr>
                  <th class="no-sort">No</th>
                  <th>ID Pengajuan</th>
                  {{-- <th>Tgl Pengajuan</th> --}}
                  <th>Alternatif</th>
                  <th>Nama Nasabah</th>
                  <th>C1</th>
                  <th>C2</th>
                  <th>C3</th>
                  <th>C4</th>
                  <th>C5</th>
                  <th>C6</th>
                  <th>Hasil Akhir</th>
                  <th>Kesimpulan</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
            </table>
          </div>
      </div>
          <div class="box-tools pull-right">
            <br>
            <div class="btn-group">
              <a href="{{ url('proses-spk/perangkingan') }}" class="btn btn-success btn-save">{{ "Lanjut Ke Perangkingan" }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></a> 
            </div>
        </div>
      </div>
<!-- DataTable -->
<script type="text/javascript">
    let _datatables_fucom_smart = {
      dt__datatables_fucom_smart:function(){
        var _this = $("#dt_fucom_smart");
            _datatable = _this.DataTable({		
              processing: true,
              serverSide: true,
              paginate: false,
              ordering: true,
              order: [],
              searching: false,
              info: false,
              responsive: true,							
              ajax: {
								url: "{{ url('proses-spk/datatables-fucom-smart') }}",
								type: "POST",
								data: function(params){
                    params.date_start = $('#date_start').val();
                    params.date_end = $('#date_end').val();
									}
								},
              columns: [
                          {
                              data: "id_pengajuan",
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
                          // { 
                          //     data: "tgl_pengajuan", 
                          //     render: function ( val, type, row ){
                          //         return moment(val).format('DD MMMM YYYY')
                          //       }
                          // },
                          { 
                              data: "alternatif", 
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
                              data: "c1", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "c2", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "c3", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "c4", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "c5", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "c6", 
                              render: function ( val, type, row ){
                                  return val
                                }
                          },
                          { 
                              data: "hasil", 
                              render: function ( val, type, row ){
                                  return '<label class="label label-danger">' + val + '</label>'
                                }
                          },
                          { 
                              data: "kesimpulan", 
                              render: function ( val, type, row ){
                                  if(val == 'Layak'){
                                    var label = '<label class="label label-success">Layak</label>'
                                  }else{
                                    var label = '<label class="label label-warning">Tidak Layak</label>'
                                  }
                                  return label
                              }
                          },
                      ],
                      createdRow: function ( row, data, index ){		
       

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_fucom_smart.dt__datatables_fucom_smart();
    $('#date_start, #date_end').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
});

</script>
@endsection
 
