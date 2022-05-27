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
              <label for="name" class="col-sm-3 control-label">Status</label>
              <div class="col-md-9">
                <select name="f[status]" id="" class="form-control">
                  <option value="XX">Semua</option>
                  <option value="1">Diterima</option>
                  <option value="2">Tidak Diterima</option>
                </select>
              </div>
          </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <button type="sumbit" formtarget="_blank" class="btn btn-success btn-block" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Preview </button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection