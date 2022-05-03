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
                <div class="col-md-12">
                    <button type="sumbit" formtarget="_blank" class="btn btn-success btn-block" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Cetak </button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection