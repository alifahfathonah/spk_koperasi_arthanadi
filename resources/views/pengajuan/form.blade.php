<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Alternatif *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[id_pengajuan]" id="id_pengajuan" value="{{ @$item->id_pengajuan }}" placeholder="ID Pengajuan" required="" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nama Nasabah *</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="text" name="nama_nasabah" id="nama_nasabah" class="form-control" placeholder="Nama Nasabah" value="{{ @$item->nama_nasabah }}" required="" readonly>
        <input type="hidden" name="f[id_alternatif]" id="id_alternatif" class="form-control" placeholder="" value="{{ @$item->id_alternatif }}" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_nasabah" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal Alternatif *</label>
    <div class="col-lg-9">
      <input type="date" name="f[tgl_pengajuan]" id="tgl_pengajuan" class="form-control" placeholder="Tanggal Pengajuan" value="{{ @$item->tgl_pengajuan }}">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Jaminan *</label>
    <div class="col-lg-9">
      <select name="f[jaminan]" class="form-control" required="" id="jaminan">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$jaminan as $dt): ?>
          <option value="<?php echo @$dt->id ?>" <?= @$dt->id == @$item->jaminan ? 'selected': null ?>><?php echo @$dt->nama_kriteria ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Karakter *</label>
    <div class="col-lg-9">
      <select name="f[karakter]" class="form-control" required="" id="karakter">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$karakter as $dt): ?>
          <option value="<?php echo @$dt->id ?>" <?= @$dt->id == @$item->karakter ? 'selected': null ?>><?php echo @$dt->nama_kriteria ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Kemampuan *</label>
      <div class="col-lg-9">
        <div class="input-group data_collect_wrapper">
          <input type="number" class="form-control" name="f[kemampuan]" required id="kemampuan" value="{{ @$item->kemampuan }}" placeholder="Kemampuan" min="1">
          <div class="input-group-btn">
            <span class="btn btn-default btn-flat">Tahun</span>
          </div>
        </div>
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Pendapatan *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[pendapatan]" required id="pendapatan" value="{{ @$item->pendapatan }}" placeholder="Pendapatan">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Pengeluaran *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[pengeluaran]" required id="pengeluaran" value="{{ @$item->pengeluaran }}" placeholder="Pengeluaran">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Kondisi Hutang *</label>
    <div class="col-lg-9">
      <select name="f[kondisi_hutang]" class="form-control" required="" id="kondisi_hutang">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$kondisi_hutang as $dt): ?>
          <option value="<?php echo @$dt->id ?>" <?= @$dt->id == @$item->kondisi_hutang ? 'selected': null ?>><?php echo @$dt->nama_kriteria ?></option>
        <?php endforeach; ?>
      </select>
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

    $('#lookup_nasabah').dataCollect({
        ajaxUrl: "{{ url('pengajuan/lookup_alternatif') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN NASABAH',
        modalTxtSelect : 'Pilih Nasabah',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['Kode Alternatif','ID Nasabah','Nama Nasabah','Alamat'],
        dtColumns: [
            {data: "kode_alternatif"}, 
            {data: "id_nasabah"}, 
            {data: "nama_nasabah"}, 
            {data: "alamat_nasabah"}, 
        ],
        onSelected: function(data, _this){	
          $('#id_alternatif').val(data.id);
          $('#nama_nasabah').val(data.nama_nasabah);
          $('#alamat_nasabah').val(data.alamat_nasabah); 
          return true;
        }
    });

  });

  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var post_pengajuan = {
          'id_alternatif'    : $("#id_alternatif").val(),
          'tgl_pengajuan' : $("#tgl_pengajuan").val(),
          'jaminan' : $("#jaminan").val(),
          'karakter' : $("#karakter").val(),
          'kemampuan' : $("#kemampuan").val(),
          'pendapatan' : $("#pendapatan").val(),
          'pengeluaran' : $("#pengeluaran").val(),
          'kondisi_hutang' : $("#kondisi_hutang").val(),
        }
     data_post = {
          "f" : post_pengajuan,
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