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
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Operasional</th>
        </tr>
        <tr>
          <td colspan="3"><strong>Penerimaan : </strong></td>
        </tr>
        <tr>
          <td width="50%">Penerimaan Kas dari SPP</td>
          <td>Rp. {{number_format( $penerimaan_dari_spp->total, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Penerimaan Kas dari Non SPP</td>
          <td>Rp. {{number_format( 0, 2)}}</td>
        </tr>
        <tr>
          <td width="50%">Total Penerimaan</td>
          <td style="text-align: right!important">Rp. {{number_format( $penerimaan_dari_spp->total, 2)}}</td>
        </tr>
        {{-- 2 --}}
        <tr>
          <td colspan="3"><strong>Pengeluaran :</strong></td>
        </tr>
        @php $totalPengeluaran = 0 @endphp
        @foreach($pengeluaran as $row)
          @php $totalPengeluaran += $row->total; @endphp
          <tr>
            <td width="50%">{{ $row->nama_akun }}</td>
            <td>(Rp. {{number_format( $row->total, 2)}})</td>
          </tr>
        @endforeach
        <tr>
          <td width="50%">Total Pengeluaran</td>
          <td style="text-align: right!important">Rp. {{number_format( $totalPengeluaran, 2)}}</td>
        </tr>
        {{-- 3 --}}
        <tr>
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Investasi</th>
        </tr>
        <tr>
          <td width="50%">Total Arus Kas dari Aktivitas Investasi</td>
          <td>Rp. {{number_format( 0, 2)}}</td>
        </tr>
        <tr>
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Pendanaan</th>
        </tr>
        <tr>
          <td width="50%">Total Arus Kas dari Aktivitas Pendanaan</td>
          <td>Rp. {{number_format( 0, 2)}}</td>
        </tr>
        <br>
        <tr>
          <th colspan="2" style="background-color: #ddd">Saldo Kas dan Setara Kas Awal Periode</th>
          <th style="text-align: right!important">Rp. {{number_format($saldo_kas_bulan_lalu, 2)}}</th>
        </tr>
        <tr>
          <th colspan="2" style="background-color: #ddd">Saldo Kas dan Setara Kas Akhir Periode</th>
          <th style="text-align: right!important">Rp. {{number_format($penerimaan_dari_spp->total - $totalPengeluaran, 2)}}</th>
        </tr>


      </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>