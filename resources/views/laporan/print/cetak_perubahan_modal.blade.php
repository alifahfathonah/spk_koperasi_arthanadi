<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ @$title }} {{config('app.app_name')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{url('themes/default/images/favicon.ico')}}">
    <link rel="stylesheet" href="{{ url('themes/default/css/style_report.css')}}">
    <style>
      table, tr, th, td{
        border: 0px!important;
      }
    </style>
</head>
<body>
  <table style="border:none;">
    <tr>
      <td width="100px" style="border:none;"><img src="{{ url('themes/login/images/logo.png')}}" alt="" style="width: 100px;text-align:center"><br></td>
      <td style="border:none;">
        <h4 align="center">
          {{config('app.app_name')}} {{config('app.area')}} <br>
          Alamat : {{config('app.address')}} <br>Telepon : {{config('app.phone')}}
        </h4>
      </td>
      {{-- <td width="100px" style="border:none;"><img src="{{ url('themes/login/images/logo_pendidikan.png')}}" alt="" style="width: 100px;text-align:center"><br></td> --}}
    </tr>
  </table>
  <hr>
    <h5 align="center">
      {{ @$title }} <br>
      Periode : {{ $params->date_start ." s/d ". $params->date_end }}
    </h5>
    <div class="container">
      <table width="100%">
        {{-- 1 --}}
        <tr>
          <td width="50%">Anggaran</td>
          <td>Rp. {{number_format( @$anggaran, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Tambahan Anggaran Disetor</td>
          <td>Rp. {{number_format( @$tambahan_modal_disetor, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Laba Ditahan</td>
          <td>Rp. {{number_format( @$laba_ditahan, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Laba Ditahan Periode Sekarang</td>
          <td>Rp. {{number_format( @$laba_ditahan_periode_sekarang, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Penghasilan Lain</td>
          <td>Rp. {{number_format( @$penghasilan_lain, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Deviden</td>
          <td>Rp. {{number_format( @$deviden, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Komponen Ekuitas Lain</td>
          <td>Rp. {{number_format( @$komponen_ekuitas_lain, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Saldo Akhir Periode</td>
          <td>Rp. {{number_format( @$saldo_akhir_periode, 2)}}</td>
        </tr>
      </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>