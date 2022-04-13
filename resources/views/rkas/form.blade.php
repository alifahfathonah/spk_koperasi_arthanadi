<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal</label>
    <div class="col-lg-9">
      <input type="date" class="form-control" name="f[tanggal]" id="tanggal" value="{{ @$item->tanggal }}" placeholder="Tanggal" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">ID RKAS</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[id_rkas]" id="id_rkas" value="{{ @$item->id_rkas }}" placeholder="ID RKAS" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Uraian Kegiatan</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="hidden" id="akun_id" name="f[akun_id]" required value="{{ @$item->akun_id }}">
        <input type="text" name="f[keterangan]" id="keterangan" value="{{ @$item->keterangan }}" class="form-control" placeholder="Keterangan" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_akun" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Sumber Dana</label>
    <div class="col-lg-9">
      @php $sumber_dana = [
        ['id' => 'Siswa'],
        ['id' => 'Pemerintah']
      ]; 
      @endphp
      <select name="f[sumber_dana]" class="form-control" required="" id="sumber_dana">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$sumber_dana as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->sumber_dana ? 'selected': null ?>><?php echo @$dt['id'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Semester</label>
    <div class="col-lg-9">
      @php $semester = [
        ['id' => 'SMT 1'],
        ['id' => 'SMT 2'],
      ]; 
      @endphp
      <select name="f[semester]" class="form-control" required="" id="semester">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$semester as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->semester ? 'selected': null ?>><?php echo @$dt['id'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tahun Ajaran</label>
    <div class="col-lg-9">
      @php $tahun_ajaran = [
        ['id' => '2020/2021','desc' => '2020/2021'],
        ['id' => '2021/2022','desc' => '2021/2022'],
        ['id' => '2022/2023','desc' => '2022/2023'],  
      ]; 
      @endphp
      <select name="f[tahun_ajaran]" class="form-control" required="" id="tahun_ajaran">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$tahun_ajaran as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->tahun_ajaran ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Jumlah</label>
      <div class="col-lg-9">
        <input type="text" class="form-control mask-number" name="f[nominal]" id="nominal" value="{{ @$item->nominal }}" placeholder="Nominal" required="">
      </div>
  </div>
  <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Tutup</button>
        <button id="submit_form" type="submit" class="btn btn-success btn-save"><i class="fa fa-check" aria-hidden="true"></i> @if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      </div>
  </div>
</form>
      

<script type="text/javascript">
  $(document).ready(function(){
    mask_number.init();
    $('#lookup_akun').dataCollect({
        ajaxUrl: "{{ url('akun/datatables-lookup-collection') }}",
        ajaxMethod: 'GET',
			  ajaxData: function(params){
            params.golongan = 'Biaya';
			  },
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN AKUN',
        modalTxtSelect : 'Pilih Akun',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['No Akun','Nama Akun','Kelompok'],
        dtColumns: [
            {data: "kode_akun"}, 
            {data: "nama_akun"}, 
            {data: "kelompok"}, 
        ],
        onSelected: function(data, _this){	
          $('#akun_id').val(data.id);
          $('#keterangan').val(data.nama_akun); 
            
          return true;
        }
    });

  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var post_header = {
          'tanggal' : $("#tanggal").val(),
          'id_rkas' : $("#id_rkas").val(),
          'nominal' : mask_number.currency_remove($("#nominal").val()),
          'keterangan' : $("#keterangan").val(),
          'sumber_dana' : $("#sumber_dana").val(),
          'semester' : $("#semester").val(),
          'tahun_ajaran' : $("#tahun_ajaran").val(),
          'akun_id' : $("#akun_id").val(),
        }
     data_post = {
          "f" : post_header
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
  });
  return false;
});
</script>