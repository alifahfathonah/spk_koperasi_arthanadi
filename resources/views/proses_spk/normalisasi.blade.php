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
<form  method="POST" action="{{ url('proses-spk/proses-fucom-smart') }}" class="form-horizontal" name="form_proses_fucom_smart">
  {{ csrf_field() }}
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ @$title }}</h3>
      </div>
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="dt_normalisasi" width="100%">   
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
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
          <div class="box-tools pull-right">
            <a href="{{ url('proses-spk') }}" class="btn btn-primary"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Kembali</a>
            <div class="btn-group">
              <button id="submit_form" type="submit" class="btn btn-success btn-save">{{ "Perhitungan FUCOM-SMART" }} <i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
            </div>
        </div>
      </div>
    </div>
  </form>
<!-- DataTable -->
<script type="text/javascript">
    let _datatables_normalisasi = {
      dt__datatables_normalisasi:function(){
        var _this = $("#dt_normalisasi");
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
								url: "{{ url('proses-spk/datatables-normalisasi') }}",
								type: "POST",
								data: function(params){

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
                          }
                      ],
                      createdRow: function ( row, data, index ){		
       

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_normalisasi.dt__datatables_normalisasi();
});

$('form[name="form_proses_fucom_smart"]').on('submit',function(e) {
    e.preventDefault();
    if(!confirm("Apakah anda yakin memproses data ini?")) {
      return false;
    }

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data_post = {
          "details" : {},
      }

      $("#dt_normalisasi").DataTable().rows().data().each(function (value, index){
        var details_form = {
            'id_pengajuan' : value.id_pengajuan,
            'alternatif' : value.alternatif,
            'c1' : value.c1,
            'c2' : value.c2,
            'c3' : value.c3,
            'c4' : value.c4,
            'c5' : value.c5,
            'c6' : value.c6,
        }
        data_post.details[index] = details_form;
    });

    var table = $('#dt_normalisasi').DataTable();

    if ( ! table.data().any() ) {
        $.alert_error('Tidak terdapat data pengajuan');
        $('.btn-save').removeClass('disabled', true);
        $(".spinner").css("display", "none");
        return false
    }
  $.post($(this).attr("action"), data_post, function(response, status, xhr) {
      if( response.status == "error"){
          $.alert_warning(response.message);
          $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
          $.alert_success(response.message);
              setTimeout(function(){
                document.location.href = "{{ url('proses-spk/fucom-smart') }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
                return false
      });
});
</script>
@endsection
 
