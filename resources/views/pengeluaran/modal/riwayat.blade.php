<form action="{{url($submit_url)}}" method="POST">
{{csrf_field()}}
<p>
    Tanggal Pembatalan : {{ date('d-m-Y', strtotime(@$item->tanggal_dibatalkan)) }} <br>
    User               : {{ @$item->nama_user }}
</p>
<div class="modal-footer">
    <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
</div>
</form>