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
            <a id="modalCreate" class="btn btn-block btn-success"><b><i class="fa fa-exchange"></i> <?php echo 'Proses Kenaikan Kelas' ?></b></a>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form  method="POST" action="{{ url('siswa/proses_kenaikan_kelas') }}" class="form-horizontal" id="form_postings">
        {{ csrf_field() }}
          <table class="table table-striped table-bordered table-hover" id="{{ $idDatatables }}" width="100%">   
              <thead>
                <tr>
                  <th class="no-sort">
                    <div class="checkbox" title="<?php echo 'Pilih Semua' ?>">
                      <input type="checkbox" id="check-all" name="checked-all" class="" />
                      <label for="check-all">&nbsp;</label>
                    </div>
                  </th>
                  <th>NIS</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Telepon</th>
                  <th>Kelas</th>
                  <th>Agama</th>
                  <th>JK</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Lulus</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
            </table>
        </form>
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
              remote : "{{ url("$nameroutes") }}/proses_kenaikan_kelas",
              size : 'modal-md',
              title : "Konfirmasi Kenaikan Kelas",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({				
              processing: true,
							serverSide: false,								
							paginate: false,
							ordering: false,
							lengthMenu: [ 50, 75, 100, 150 ],
							order: [[1, 'desc']],
							searching: false,
							info: true,
							responsive: true,					
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
                              render: function ( val, type, row, meta ){
                                return 	'<div class="checkbox">' +
                                      '<input type="checkbox"  id="row'+ meta.row +'" name="siswa[][id]" data class=\"post-check\" value ="'+ val +'" >' +
                                      '<label for="row'+ meta.row +'">&nbsp;</label>' +
                                    '</div>';
                              }
                          },
                          { 
                                data: "nis", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama", 
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
                                    return val
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
                                data: "tempat_lahir", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal_lahir", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tamat", 
                                render: function ( val, type, row ){
                                    if(val == 1)
                                    {
                                      return "<label class=\"label label-success\">Lulus</label>";
                                    }
                                    else{
                                      return "<label class=\"label label-warning\">Belum</label>";
                                    }
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
    _datatables_show.dt__datatables_show();
    lookup.lookup_modal_create();

    $("#check-all").on("change", function(e){
					
					$(".post-check").prop('checked', $(this).prop("checked"));
					
					$(this).prop("checked") 
						? $(".post-check").closest( 'tr' ).addClass('danger')
						: $(".post-check").closest( 'tr' ).removeClass('danger');
				});
				
});
</script>

</div>
@endsection
 
