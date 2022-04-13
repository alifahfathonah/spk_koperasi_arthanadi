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
      {{ @$title }} SMP WIDYA SUARA SUKAWATI <br>
      Tahun Ajaran {{ @$params->periode }}
    </h5>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <td style="text-align: center!important" rowspan="4"><strong>No</strong></td>
              <td rowspan="4"><strong>Uraian Kegiatan</strong></td>
              <td colspan="4" align="center"><strong>Sumber Dana</strong></td>
            </tr>
            <tr>
              <td colspan="2" align="center"><strong>Pemerintah</strong></td>
              <td colspan="2" align="center"><strong>Sumbangan Komite</strong></td>
            </tr>
            <tr>
              <td align="center"><strong>SMT 1</strong></td>
              <td align="center"><strong>SMT 2</strong></td>
              <td align="center"><strong>SMT 1</strong></td>
              <td align="center"><strong>SMT 2</strong></td>
            </tr>
            <tr>
              <td align="center">1</td>
              <td align="center">2</td>
              <td align="center">3</td>
              <td align="center">4</td>
            </tr>
            <tr>
              <td align="center">1.1</td>
              <td><strong>STANDAR SARANA PRASARANA</strong></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
            </tr>
          </thead>
          <tbody>
            <?php  $no = 1; $total_smt1_pemerintah = 0; $total_smt2_pemerintah = 0; $total_smt1_siswa = 0; $total_smt2_siswa = 0;?>
            @if(!$item->isEmpty()) 
              @foreach($item as $row)
                @php 
                  $total_smt1_pemerintah += ($row->semester == 'SMT 1' && $row->sumber_dana == 'Pemerintah') ? $row->nominal : 0; 
                  $total_smt2_pemerintah += ($row->semester == 'SMT 2' && $row->sumber_dana == 'Pemerintah') ? $row->nominal : 0; 
                  $total_smt1_siswa += ($row->semester == 'SMT 1' && $row->sumber_dana == 'Siswa') ? $row->nominal : 0; 
                  $total_smt2_siswa += ($row->semester == 'SMT 2' && $row->sumber_dana == 'Siswa') ? $row->nominal : 0; 
                @endphp
                <tr>
                  <td align="center">{{ $row->id_rkas }}</td>
                  <td>{{ $row->keterangan }}</td>
                  <td align="right">Rp. {{ ($row->semester == 'SMT 1' && $row->sumber_dana == 'Pemerintah') ? number_format($row->nominal) : 0 }}</td>
                  <td align="right">Rp. {{ ($row->semester == 'SMT 2' && $row->sumber_dana == 'Pemerintah') ? number_format($row->nominal) : 0 }}</td>
                  <td align="right">Rp. {{ ($row->semester == 'SMT 1' && $row->sumber_dana == 'Siswa') ? number_format($row->nominal) : 0 }}</td>
                  <td align="right">Rp. {{ ($row->semester == 'SMT 2' && $row->sumber_dana == 'Siswa') ? number_format($row->nominal) : 0 }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" align="center">Tidak terdapat data</td>
              </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="2" align="right"><strong> Jumlah</strong></td>
              <td align="right"><strong>Rp. {{ number_format($total_smt1_pemerintah) }}</strong></td>
              <td align="right"><strong>Rp. {{ number_format($total_smt2_pemerintah) }}</strong></td>
              <td align="right"><strong>Rp. {{ number_format($total_smt1_siswa) }}</strong></td>
              <td align="right"><strong>Rp. {{ number_format($total_smt2_siswa) }}</strong></td>
            </tr>
          </tfoot>

        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>