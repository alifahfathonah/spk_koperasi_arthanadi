<form method="POST" action="{{ url(@$submit_url) }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <label>Pilih file excel (.xls)</label>
    <div class="form-group">
      <input type="file" name="file" required="required" class="form-control">
    </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-success">{{ __('global.label_import') }}</button>
  </div>
</form>