<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">ID Simpanan *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[id_simpanan]" id="id_simpanan" value="{{ @$item->id_simpanan }}" placeholder="ID Simpanan" required="" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nama Anggota *</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" placeholder="Nama Anggota" value="{{ @$item->nama_anggota }}" required="" readonly>
        <input type="hidden" name="f[id_anggota]" id="id_anggota" class="form-control" placeholder="ID Anggota" value="{{ @$item->id_anggota }}" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_anggota" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal *</label>
    <div class="col-lg-9">
      <input type="date" name="f[tanggal]" id="tanggal" class="form-control" placeholder="Tanggal" value="{{ @$item->tanggal }}">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Saldo *</label>
    <div class="col-lg-9">
      <input type="text" name="f[saldo_awal]" id="saldo_awal" class="form-control mask-number" placeholder="Saldo Awal" value="{{ @$item->saldo_awal }}" readonly>
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Nominal *</label>
      <div class="col-lg-9">
        <input type="text" class="form-control mask-number" name="f[nominal]" id="nominal" value="{{ @$item->nominal }}" placeholder="Nominal" required="">
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Saldo Akhir *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control mask-number" name="f[saldo_akhir]" id="saldo_akhir" value="{{ @$item->saldo_akhir }}" placeholder="Saldo Akhir" required="" readonly>
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
  $(document).ready(calculate);   
  $(document).on("keyup",'#nominal', calculate);

  function calculate() {
      var saldo_awal = mask_number.currency_remove($('#saldo_awal').val());
          nominal = mask_number.currency_remove($('#nominal').val());
          saldo_akhir = parseFloat(saldo_awal) + parseFloat(nominal);

          $("#saldo_akhir").val(mask_number.currency_add(saldo_akhir));
  }

	$( document ).ready(function(e) {
    mask_number.init()

    $('#lookup_anggota').dataCollect({
        ajaxUrl: "{{ url('anggota/datatables') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN ANGGOTA',
        modalTxtSelect : 'Pilih Anggota',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['ID Anggota','Nama Anggota','Tanggal Masuk','Alamat'],
        dtColumns: [
            {data: "id_anggota"}, 
            {data: "nama_anggota"}, 
            {data: "tanggal_masuk"}, 
            {data: "alamat"}, 
        ],
        onSelected: function(data, _this){	
          $('#id_anggota').val(data.id);
          $('#nama_anggota').val(data.nama_anggota);
          $.get("{{ url('get-saldo') }}/" + data.id, function(response, status, xhr) {
            $('#saldo_awal').val(mask_number.currency_add(response));
          }); 
          return true;
        }
    });

  });

  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var post_simpanan = {
          'id_anggota' : $("#id_anggota").val(),
          'tanggal' : $("#tanggal").val(),
          'saldo_awal' : mask_number.currency_remove($("#saldo_awal").val()),
          'nominal' : mask_number.currency_remove($("#nominal").val()),
          'saldo_akhir' : mask_number.currency_remove($("#saldo_akhir").val()),
        }
     data_post = {
          "f" : post_simpanan,
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