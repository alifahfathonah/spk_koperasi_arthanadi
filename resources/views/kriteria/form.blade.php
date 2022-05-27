<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">Kode *</label>
    <div class="col-lg-9">
      <select name="f[kode_kriteria]" class="form-control" required="" id="kode_kriteria">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$kriteria as $dt): ?>
          <option value="<?php echo @$dt->kode_kriteria ?>" <?= @$dt->kode_kriteria == @$item->kode_kriteria ? 'selected': null ?>><?php echo @$dt->kode_kriteria ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Keterangan *</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" name="f[nama_kriteria]" id="nama_kriteria" value="{{ @$item->nama_kriteria }}" placeholder="Nama Kriteria" required="">
      </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Bobot Kriteria *</label>
      <div class="col-lg-9">
        <input type="number" class="form-control" name="f[bobot_kriteria]" id="bobot_kriteria" value="{{ @$item->bobot_kriteria }}" placeholder="Bobot Kriteria" required="">
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
  $(document).ready(function() {
      mask_number.init();
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'kode_kriteria' : $("#kode_kriteria").val(),
          'nama_kriteria' : $("#nama_kriteria").val(),
          'bobot_kriteria' : $("#bobot_kriteria").val(),
        }
     data_post = {
          "f" : data,
        }

  $.post($(this).attr("action"), data_post, function(response, status, xhr) {
      if( response.status == "error"){
          $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
          $.alert_success(response.message);
              ajax_modal.hide();
              setTimeout(function(){
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
            $(".spinner").css("display", "none");
            return false
      });
});
</script>