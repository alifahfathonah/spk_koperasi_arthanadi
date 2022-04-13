@extends('themes.AdminLTE.layouts.template')
@section('content')
<div class="col-sm-6 col-sm-offset-3 col-xs-12">
<div class="box box-primary">
    <div class="box-header with-border">
      <h4 class="box-title">{{ @$title }}</h4>
    </div>
  <div class="row">
    <div class="box-body">
        <div class="col-md-12">
            <form  method="POST" action="{{ url(@$url_print) }}" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="form-group">
              <label class="col-lg-3 control-label">Nama Siswa *</label>
              <div class="col-lg-9">
                <div class="input-group data_collect_wrapper">
                  <input type="hidden" name="f[nis]" id="nis" class="form-control" placeholder="NIS" value="{{ @$item->nis }}" required="" readonly>
                  <input type="text" name="f[nama_siswa]" id="nama_siswa" class="form-control" placeholder="Nama Siswa" value="{{ @$item->nama_siswa }}" required="" readonly>
                  <div class="input-group-btn">
                    <a href="javascript:;" id="lookup_siswa" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-lg-3 control-label">Tahun Ajaran *</label>
              <div class="col-lg-9">
                  <select name="f[tahun_ajaran]" class="form-control" required="" id="tahun_ajaran">
                    <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
                    <?php foreach(@$option_tahun_ajaran as $dt): ?>
                      <option value="{{ $dt['id'] }}" <?= @$dt['id'] == @$item->tahun_ajaran ? 'selected': null ?>>{{ $dt['desc'] }}</option>
                    <?php endforeach; ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <button type="sumbit" formtarget="_blank" class="btn btn-success btn-block" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Cetak PDF</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<script>
  $(document).ready(function(){
    $('#lookup_siswa').dataCollect({
        ajaxUrl: "{{ url('datatables-siswa') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN SISWA',
        modalTxtSelect : 'Pilih Siswa',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['NIS','Nama Siswa','Angkatan','Kelas'],
        dtColumns: [
            {data: "nis"}, 
            {data: "nama_siswa"}, 
            {data: "angkatan"}, 
            {data: "tingkat_kelas"}, 
        ],
        onSelected: function(data, _this){	
          $('#nis').val(data.nis);
          $('#nama_siswa').val(data.nama_siswa); 
            
          return true;
        }
    });
  })
</script>
@endsection