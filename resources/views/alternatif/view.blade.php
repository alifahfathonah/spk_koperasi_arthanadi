<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Anggota</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->id_anggota }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nama Anggota</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->nama_anggota }}</label>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Tanggal Masuk</label>
      <div class="col-lg-9">
        : <label class="control-label">{{ date('d/m/Y', strtotime(@$item->tanggal_masuk)) }}</label>
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal Lahir</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ date('d/m/Y', strtotime(@$item->tanggal_lahir)) }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Alamat</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->alamat }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Telepon</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->telepon }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Agama</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->agama }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Pekerjaan</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->pekerjaan }}</label>
    </div>
  </div>
</form>
      
