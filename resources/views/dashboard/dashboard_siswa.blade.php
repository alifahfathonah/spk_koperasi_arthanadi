@extends('themes.AdminLTE.layouts.template')
@section('content')
<section class="content-header">
  <h1 align="center">
    <strong>{{ config('app.app_name') }}</strong>
  </h1>
</section>
<br><br>
<h2 align="center">Selamat datang, {{ Session::get('nama') }}</h2>

        </section>
      </div>
      <!-- /.col -->
    <!-- /.row -->
  
    @endsection