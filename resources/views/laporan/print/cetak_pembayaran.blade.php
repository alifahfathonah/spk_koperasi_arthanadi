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
      Periode : {{ $params->date_start ." s/d ". $params->date_end }}
    </h5>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <th style="text-align: center!important">No</th>
              <th>Tanggal</th>
              <th>NIS</th>
              <th>Nama Siswa</th>
              <th>Kelas</th>
              <th>Jenis Kelamin</th>
              <th>Jumlah</th>
            </tr>
          </thead>
          <tbody>
            <?php  $no = 1;$total = 0; ?>
            @if(!$item->isEmpty()) 
              @foreach($item as $row)
                @php $total += $row->nominal; @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ date('d M Y',strtotime($row->tgl_pembayaran)) }}</td>
                  <td>{{ $row->nis }}</td>
                  <td>{{ $row->nama }}</td>
                  <td>{{ $row->kelas }}</td>
                  <td>{{ $row->jenis_kelamin }}</td>
                  <td>Rp. {{ number_format($row->nominal, 2) }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="7" align="center">Tidak terdapat data</td>
              </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="6" align="right"><b>TOTAL</b></td>
              <td><b>Rp. {{ number_format($total, 2) }}</b></td>
            </tr>
          </tfoot>
        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>