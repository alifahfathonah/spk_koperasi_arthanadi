<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="box-body">
    <div class="col-md-12">
      <div class="form-group">
        <label class="col-lg-3 control-label">ID Pembayaran</label>
        <div class="col-lg-9">
          <input type="text"  class="form-control" name="f[id_pembayaran]" id="id_pembayaran" value="{{ @$item->id_pembayaran }}"  required="" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Tanggal</label>
        <div class="col-lg-9">
          <input type="date" name="f[tgl_pembayaran]" id="tgl_pembayaran" class="form-control" placeholder="Tanggal" value="{{ @$item->tgl_pembayaran }}" required="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Nama Siswa</label>
        <div class="col-lg-9">
          <div class="input-group data_collect_wrapper">
            <input type="text" name="f[nama_siswa]" id="nama_siswa" class="form-control" placeholder="Nama Siswa" value="{{ @$item->nama_siswa }}" required="" readonly>
            <input type="hidden" name="f[nis]" id="nis" class="form-control" placeholder="NIS" value="{{ @$item->nis }}" required="" readonly>
            <div class="input-group-btn">
              <a href="javascript:;" id="lookup_siswa" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Kelas</label>
        <div class="col-lg-9">
            <input type="text" name="f[kelas]" id="kelas" class="form-control" placeholder="Kelas" value="{{ @$item->kelas }}" required="" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Jurusan</label>
        <div class="col-lg-9">
            <input type="text" name="f[jurusan]" id="jurusan" class="form-control" placeholder="Jurusan" value="{{ @$item->jurusan }}" required="" readonly>
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Semester</label>
        <div class="col-lg-9">
            {!! Form::select('f[semester]',  $option_semester, @$item->semester, ['class' => 'form-control', 'required','id' => 'semester']) !!}
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Bulan</label>
        <div class="col-lg-9">
            {!! Form::select('f[bulan]',  $option_bulan, @$item->bulan, ['class' => 'form-control', 'required','id' => 'bulan']) !!}
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Jumlah Setoran</label>
        <div class="col-lg-9">
          <div class="input-group">
            <div class="input-group-btn">
              <a href="javascript:;" class="btn btn-default btn-flat">Rp</a>
            </div>
            <input type="text" name="f[nominal]" id="nominal" class="form-control mask-number" placeholder="Nominal" value="{{ (empty(@$item->nominal)) ? 125000 : @$item->nominal }}" required="">
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label class="col-lg-3 control-label">Keterangan</label>
        <div class="col-lg-9">
          <input type="text" name="f[keterangan]" id="keterangan" class="form-control" placeholder="Keterangan" value="{{ @$item->keterangan }}" required="">
        </div>
      </div>
    </div>
  </div>
  <div class="box-footer">
    <div class="pull-right">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
      <button id="submit_form" type="submit" class="btn btn-success">Simpan <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
    </div>
  </div>
</form>

<script type="text/javascript">
	$( document ).ready(function(e) {
    mask_number.init()

    $('#lookup_siswa').dataCollect({
        ajaxUrl: "{{ url('siswa/datatables') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN SISWA',
        modalTxtSelect : 'Pilih Siswa',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['NIS','Nama Siswa','Kelas','Jurusan'],
        dtColumns: [
            {data: "nis"}, 
            {data: "nama"}, 
            {data: "kelas"}, 
            {data: "jurusan"}, 
        ],
        onSelected: function(data, _this){	
          $('#nis').val(data.nis);
          $('#nama_siswa').val(data.nama); 
          $('#kelas').val(data.kelas); 
          $('#jurusan').val(data.jurusan); 
          return true;
        }
    });

  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'nis' : $("#nis").val(),
        }
        detail = {
          'tgl_pembayaran' : $("#tgl_pembayaran").val(),
          'nominal' : mask_number.currency_remove($("#nominal").val()),
          'keterangan' : $("#keterangan").val(),
          'semester' : $("#semester").val(),
          'bulan' : $("#bulan").val(),
          'kelas' : $("#kelas").val(),
          'jurusan' : $("#jurusan").val(),
          'nis' : $("#nis").val(),
        }
     data_post = {
          "f" : data,
          "details" :detail
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