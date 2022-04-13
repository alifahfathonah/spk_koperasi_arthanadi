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
      {{-- <td width="100px" style="border:none;"><img src="{{ url('themes/login/images/logo.png')}}" alt="" style="width: 100px;text-align:center"><br></td> --}}
    </tr>
  </table>
  <hr>
    <h5 align="center">
      {{ @$title }} <br>
      Periode : {{ $params->date_start ." s/d ". $params->date_end }}
    </h5>
    <p>
      NIS : {{ @$siswa->nis }} <br>
      Nama : {{ @$siswa->nama }} <br>
      Kelas : {{ @$siswa->kelas }} <br>
    </p>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <th>Bulan</th>
              <th>Tanggal</th>
              <th>Jumlah</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @foreach($item as $row)
            @php $total += @$row->nominal; @endphp
            <tr>
              <td>
                @if(@$row->bulan == 1)
                    {{ 'Januari' }}
                @elseif(@$row->bulan == 2)
                    {{ 'Februari' }}
                @elseif(@$row->bulan == 3)
                    {{ 'Maret' }}
                @elseif(@$row->bulan == 4)
                    {{ 'April' }}
                @elseif(@$row->bulan == 5)
                    {{ 'Mei' }}
                @elseif(@$row->bulan == 6)
                    {{ 'Juni' }}
                @elseif(@$row->bulan == 7)
                    {{ 'Juli' }}
                @elseif(@$row->bulan == 8)
                    {{ 'Agustus' }}
                @elseif(@$row->bulan == 9)
                    {{ 'September' }}
                @elseif(@$row->bulan == 10)
                    {{ 'Oktober' }}
                @elseif(@$row->bulan == 11)
                    {{ 'November' }}
                @elseif(@$row->bulan == 12)
                    {{ 'Desember' }}
                @endif
                {{ date('Y', strtotime(@$row->tgl_pembayaran)) }}
              </td>
              <td>{{ date('d/m/Y', strtotime(@$row->tgl_pembayaran)) }}</td>
              <td>Rp. {{ number_format(@$row->nominal, 2)}}</td>
              <td>Lunas</td>
            </tr>
            @endforeach

          </tbody>

        </table>
        <h5 align="right">TOTAL : Rp. {{ number_format(@$total, 2) }}</h5>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>