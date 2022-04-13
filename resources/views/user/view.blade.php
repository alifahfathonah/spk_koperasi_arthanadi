<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Pengguna</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->id_pengguna }}</label>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Nama Pengguna</label>
      <div class="col-lg-9">
        : <label class="control-label">{{ @$item->nama_pengguna }}</label>
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Username</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->username }}</label>
    </div>
</div>
<div class="form-group">
  <label class="col-lg-3 control-label">Password</label>
  <div class="col-lg-9">
    : <label class="control-label">{{ '*******************' }}</label>
  </div>
</div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Jabatan</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->jabatan }}</label>
    </div>
  </div>
</form>
      
