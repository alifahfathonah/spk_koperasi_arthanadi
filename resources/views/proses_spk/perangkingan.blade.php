@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li><a href="{{ url('proses-spk/fucom-smart') }}">Hasil Perhitungan</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
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

    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Hasil Perangkingan</h3>
      </div>
      <div class="table-responsive">
        <div class="box-body">
          <table class="table table-striped table-bordered table-hover" id="dt_perangkingan" width="100%">   
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
                  <th>Hasil</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
            </table>
          </div>
        </div>
      </div>
<!-- DataTable -->

<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Hasil Perangkingan Setelah Diurutkan</h3>
  </div>
  <div class="table-responsive">
    <div class="box-body">
      <table class="table table-striped table-bordered table-hover" id="dt_perangkingan_diurutkan" width="100%">   
          <thead>
            <tr>
              <th>Urutan</th>
              <th>Alternatif</th>
              <th>Nama Nasabah</th>
              <th>Hasil Akhir</th>
              <th>Kesimpulan</th>
            </tr>
          </thead>
          <tbody>
          
        </tbody>
        </table>
      </div>
    </div>
  </div>

<script type="text/javascript">
    let _datatables_perangkingan = {
      dt__datatables_perangkingan:function(){
        var _this = $("#dt_perangkingan");
            _datatable = _this.DataTable({		
              processing: true,
              serverSide: true,
              paginate: false,
              ordering: true,
              order: [1, 'asc'],
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
                              data: "alternatif", 
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
                      ],
                      createdRow: function ( row, data, index ){		
       

                      }
                                                  
                  });
							
                  return _this;
				}
			}


      // ==========================
      let _datatables_perangkingan_diurutkan = {
      dt__datatables_perangkingan_diurutkan:function(){
        var _this = $("#dt_perangkingan_diurutkan");
            _datatable_urutan = _this.DataTable({		
              processing: true,
              serverSide: true,
              paginate: false,
              ordering: true,
              order: [3, 'desc'],
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
                                var urutan = meta.row + meta.settings._iDisplayStart + 1;
                                  return 'Hasil Terbaik ' + urutan
                              }
                          },
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
    _datatables_perangkingan.dt__datatables_perangkingan();
    _datatables_perangkingan_diurutkan.dt__datatables_perangkingan_diurutkan();
    $('#date_start, #date_end').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
        _datatable_urutan.ajax.reload();
    });
});

</script>
@endsection
 
