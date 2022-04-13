<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Pengguna *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[id_pengguna]" id="id_pengguna" value="{{ @$item->id_pengguna }}" placeholder="ID Pengguna" required="" readonly>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Nama Pengguna *</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" name="f[nama_pengguna]" id="nama_pengguna" value="{{ @$item->nama_pengguna }}" placeholder="Nama Pengguna" required="">
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Jabatan *</label>
    <div class="col-lg-9">
      <select name="f[jabatan]" class="form-control" required="" id="jabatan">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_jabatan as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->jabatan ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Username *</label>
    <div class="col-lg-9">
      <input type="text" name="f[username]" id="username" class="form-control" placeholder="Username" value="{{ @$item->username }}">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Password *</label>
    <div class="col-lg-9">
      <input type="password" name="f[password]" id="password" class="form-control" placeholder="Password" value="{{ @$item->password }}">
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
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var post_user = {
          'nama_pengguna' : $("#nama_pengguna").val(),
          'username' : $("#username").val(),
          'password' : $("#password").val(),
          'jabatan' : $("#jabatan").val(),
        }
     data_post = {
          "f" : post_user,
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