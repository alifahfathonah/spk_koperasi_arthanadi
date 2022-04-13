<form  method="POST" action="" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Nasabah</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->id_nasabah }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nama Nasabah</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->nama_nasabah }}</label>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Alamat</label>
      <div class="col-lg-9">
        : <label class="control-label">{{ @$item->alamat_nasabah }}</label>
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Telepon</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->telepon }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">No KTP</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->no_ktp }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Jenis Kelamin</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ (@$item->jenis_kelamin == 'L') ? 'Laki-Laki':'Perempuan'  }}</label>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Agama</label>
    <div class="col-lg-9">
      : <label class="control-label">{{ @$item->agama }}</label>
    </div>
  </div>
</form>
      
