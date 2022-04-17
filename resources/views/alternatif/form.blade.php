<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">Kode Alternatif *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[kode_alternatif]" id="kode_alternatif" value="{{ @$item->kode_alternatif }}" placeholder="Kode Alternatif" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Data Pengajuan *</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="text" name="nama_nasabah" id="nama_nasabah" class="form-control" placeholder="Nama Nasabah" value="{{ @$item->nama_nasabah }}" required="" readonly>
        <input type="hidden" name="f[id_pengajuan]" id="id_pengajuan" class="form-control" placeholder="ID Pengajuan" value="{{ @$item->pengajuan_id }}" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_pengajuan" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('global.label_close') }}</button>
        <button id="submit_form" type="submit" class="btn btn-success btn-save">@if($is_edit) {{ __('global.label_update') }} @else {{ __('global.label_save') }} @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      </div>
  </div>
</form>
      

<script type="text/javascript">
	$( document ).ready(function(e) {
    mask_number.init()

    $('#lookup_pengajuan').dataCollect({
        ajaxUrl: "{{ url('pengajuan/datatables') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN NASABAH',
        modalTxtSelect : 'Pilih Nasabah',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['ID Pengajuan','Tanggal Pengajuan','Nama Nasabah'],
        dtColumns: [
            {data: "id_pengajuan"}, 
            {data: "tgl_pengajuan"}, 
            {data: "nama_nasabah"}, 
        ],
        onSelected: function(data, _this){	
          $('#id_pengajuan').val(data.id);
          $('#nama_nasabah').val(data.nama_nasabah);
          return true;
        }
    });

  });

  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var post = {
          'id_pengajuan'    : $("#id_pengajuan").val(),
          'kode_alternatif' : $("#kode_alternatif").val()
        }
     data_post = {
          "f" : post,
        }

    $.ajax({
        url: $(this).prop('action'),
        type: 'POST',              
        data: data_post,
        success: function(response, status, xhr)
        {
          if( response.status == "error"){
              $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
            
          $.alert_success(response.message);
              setTimeout(function(){
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
          },
        error: function(error)
        {
          $.alert_error(error);
          $('.btn-save').removeClass('disabled', true);
          $(".spinner").css("display", "none");
          return false
        }
    });
});
</script>