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
      table, tr, th,td{
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
    <div class="col-sm-12">
      <div class="">
          <table class="table">
              <thead>
                  <tr>
                      <th align="center"><b>ASET</b></th>
                      <th align="center"><b>LIABILITAS</b></th>                        
                  </tr> 
              </thead>
              <tbody>	
                  <tr>
                      <td width="50%">
                          <table>
                              <tr>
                                <td colspan="2"><b>Aset Lancar</b></td>
                              </tr>
                                <tr>
                                  <td width="50%" style="padding-left: 20px">Kas</td>
                                  <td>Rp. {{ number_format(@$kas, 2)}}</td>
                                </tr>
                              <tr>
                                <td><b>Total Aset Lancar</b></td>
                                <td><b>Rp. {{ number_format(@$kas, 2) }}</b></td>
                              </tr>
                              <tr>
                                <td colspan="2" style="padding-top: 20px"><b>Aset Tetap</b></td>
                              </tr>
                              <tr>
                                <td width="50%" style="padding-left: 20px">Aset Tetap</td>
                                <td>Rp. {{ number_format(@$aktiva_tetap, 2)}}</td>
                              </tr>
                              <tr>
                                <td width="50%" style="padding-left: 20px">Akum. Peny Aset Tetap</td>
                                <td>( Rp. {{ number_format(@$akumulasi_penyusutan, 2)}} )</td>
                              </tr>
                              <tr>
                                <td><b>Total Aset Tetap</b></td>
                                <td><b>Rp. {{ number_format(@$aktiva_tetap - @$akumulasi_penyusutan, 2) }}</b></td>
                              </tr>
                          </table>
                        <br>
                       
                      </td>
                      <?php $total_aktiva = @$kas + (@$aktiva_tetap - @$akumulasi_penyusutan); ?>
                      <?php $total_pasiva = @$utang_gaji + (@$total_aktiva - @$utang_gaji); ?>
                      {{-- ============= PASIVA ============ --}}
                      <td width="50%">
                          <table>
                              <tr>
                                <td colspan="2"><b>Utang Jangka Pendek</b></td>
                              </tr>
                              <tr>
                                <td width="50%" style="padding-left: 20px">Utang Gaji</td>
                                <td>Rp. {{ number_format(@$utang_gaji, 2) }}</td>
                              </tr>
                              <tr>
                                <td><b>Total Utang Jangka Pendek</b></td>
                                <td><b>Rp. {{ number_format(@$utang_gaji, 2) }}</b></td>
                              </tr>

                              <tr>
                                <td colspan="2" style="padding-top: 20px"><b>Modal</b></td>
                              </tr>
                              <tr>
                                <td width="50%" style="padding-left: 20px">Modal di Setor</td>
                                <td>Rp. {{ number_format(@$total_aktiva - @$utang_gaji, 2) }}</td>
                              </tr>
                              <tr>
                                <td><b>Total Modal</b></td>
                                <td><b>Rp. {{ number_format(@$total_aktiva - @$utang_gaji, 2) }}</b></td>
                              </tr>

                          </table>
                        <br>
                        <br>
    
                      
                      </td>
                  </tr>
              </tbody>
          </table>
          <table>
            <tr>
              <td width="50%">
                <table>
                  <tr>
                    <td width="50%"><b>TOTAL AKTIVA</b></td>
                    <td><b>Rp. {{ number_format(@$total_aktiva, 2)  }}</td>
                  </tr>
                </table>
              </td>
              <td width="50%">
                <table>
                  <tr>
                    <td width="50%"><b>TOTAL PASSIVA</b></td>
                    <td><b>Rp. {{ number_format(@$total_pasiva, 2)  }}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>


      </div>
  </div>

    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>