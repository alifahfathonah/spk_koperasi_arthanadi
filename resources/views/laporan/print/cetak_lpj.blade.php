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
      {{ @$title }} <br> SMP WIDYA SUARA SUKAWATI <br>
      Tahun Ajaran : {{ $params->periode }}
    </h5>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <th style="text-align: center!important">No</th>
              <th>Kode Akun</th>
              <th>Keterangan</th>
              <th>Anggaran</th>
              <th>Pengeluaran</th>
            </tr>
          </thead>
          <tbody>
            <?php  $no = 1;$angaran = 0;$pengeluaran = 0; ?>
              @foreach($item as $row)
                @php $angaran += $row['anggaran']; $pengeluaran += $row['pengeluaran'];  @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ $row['kode_akun'] }}</td>
                  <td>{{ $row['keterangan'] }}</td>
                  <td align="right">Rp. {{ number_format($row['anggaran']) }}</td>
                  <td align="right">Rp. {{ number_format($row['pengeluaran']) }}</td>
                </tr>
              @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td align="right" colspan="3"><strong>TOTAL</strong></td>
              <td align="right"><strong>Rp. {{ number_format($angaran) }}</strong></td>
              <td align="right"><strong>Rp. {{ number_format($pengeluaran) }}</strong></td>
            </tr>
          </tfoot>

        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>