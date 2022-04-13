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
      {{ @$title }} <br>
      Semester {{ ($params->semester == 1) ? 'Ganjil' : 'Genap' }} <br>
      Kelas {{ $params->kelas }}
    </h5>
    <div class="container">
      <?php  $no = 1; ?>
        <table width="100%">
          <thead>
            <tr>
              <td style="text-align: center!important"  rowspan="2"><b>No</b></td>
              <td rowspan="2"><b>NIS</b></td>
              <td rowspan="2"><b>Nama</b></td>
              <td colspan="6" align="center"><b>Bulan</b></td>
              <td rowspan="2" align="center"><b>Jumlah</b></td>
            </tr>
            <tr>
              <td><b>Januari</b></td>
              <td><b>Pebruari</b></td>
              <td><b>Maret</b></td>
              <td><b>April</b></td>
              <td><b>Mei</b></td>
              <td><b>Juni</b></td>
            </tr>
          </thead>
          <tbody>
              @foreach($item as $row)
                @php $subtotal = $row['januari'] + $row['pebruari'] + $row['maret'] + $row['april'] + $row['mei'] + $row['juni'] @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ $row['nis'] }}</td>
                  <td>{{ $row['nama'] }}</td>
                  <td>Rp. {{ number_format($row['januari'],2) }}</td>
                  <td>Rp. {{ number_format($row['pebruari'],2) }}</td>
                  <td>Rp. {{ number_format($row['maret'],2) }}</td>
                  <td>Rp. {{ number_format($row['april'], 2) }}</td>
                  <td>Rp. {{ number_format($row['mei'], 2) }}</td>
                  <td>Rp. {{ number_format($row['juni'], 2) }}</td>
                  <td>Rp. {{ number_format($subtotal, 2) }}</td>
                </tr>
              @endforeach
          </tbody>

        </table>

      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>