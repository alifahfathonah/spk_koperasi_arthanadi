<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">NIS</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->nis }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nama Siswa</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->nama }}</label>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Tempat Lahir</label>
      <div class="col-lg-9">
        : <label class="control-label">{{ @$item->tempat_lahir }}</label>
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal Lahir</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->tanggal_lahir }}</label>
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
      : <label class="control-label">{{ @$item->no_telp }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Jenis Kelamin</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->jenis_kelamin }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Agama</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->agama }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Kelas</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->kelas }}</label>
    </div>
  </div>
</form>
      
