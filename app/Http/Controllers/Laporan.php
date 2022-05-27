<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use GuzzleHttp\Psr7\Response as Psr7Response;
use PDF;
use Helpers;
use Response;

class Laporan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function pengajuan()
   {
            $item = [
                'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                'date_end'   => Carbon::now()->endOfMonth()->toDateString()
            ];

            $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Pengajuan',
                'url_print'         => 'laporan/pengajuan/print'
            );

            return view('laporan.form.pengajuan', $data);

    }

    public function print_pengajuan(Request $request)
    {
        $params = $request->input('f');
        $query = DB::table("tb_pengajuan as a")
                        ->join('tb_alternatif as xx','a.id_alternatif','=','xx.id')
                        ->join('tb_nasabah as b','xx.id_nasabah','=','b.id')
                        ->join('tb_kriteria as c','a.jaminan','=','c.id')
                        ->join('tb_kriteria as d','a.karakter','=','d.id')
                        ->join('tb_kriteria as e','a.kondisi_hutang','=','e.id')
                        ->whereBetween('a.tgl_pengajuan',[$params['date_start'],$params['date_end']])
                        ->select(
                            'xx.kode_alternatif',
                            'a.*',
                            'b.nama_nasabah',
                            'b.alamat_nasabah',
                            'b.telepon',
                            'c.nama_kriteria as C1',
                            'd.nama_kriteria as C2',
                            'e.nama_kriteria as C6'
                        )
                        ->orderBy( 'a.tgl_pengajuan', 'asc')
                        ->get();
        
        $data = [
            'params'       => (object) $params,
            'item'         => $query,
            'title'        => 'LAPORAN PENGAJUAN',
        ];

        $pdf = PDF::loadView('laporan.print.cetak_pengajuan', $data, $params)->setPaper('a4', 'landscape');
        return $pdf->stream($params['date_start'].$params['date_end'].'laporan_pengajuan.pdf'); 
    }

    public function hasil_perhitungan()
    {
             $item = [
                 'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                 'date_end'   => Carbon::now()->endOfMonth()->toDateString()
             ];
 
             $data = array(
                 'item'              => (object) $item,
                 'title'             => 'Laporan Hasil Alternatif Keputusan',
                 'url_print'         => 'laporan/hasil-perhitungan/print'
             );
 
             return view('laporan.form.hasil_perhitungan', $data);
 
     }
 
     public function print_hasil_perhitungan(Request $request)
     {
         $params = $request->input('f');
         $query = DB::table('tb_hasil as a')
                ->join('tb_pengajuan as b','a.id_pengajuan','=','b.id_pengajuan')
                ->join('tb_alternatif as c','b.id_alternatif','=','c.id')
                ->join('tb_nasabah as d','c.id_nasabah','=','d.id')
                ->select(
                    'a.*',
                    'b.tgl_pengajuan',
                    'd.nama_nasabah'
                )
                ->orderBy('a.hasil', 'desc');

            if($params['status'] == 1){
                $query->where('a.kesimpulan','Layak');
            }
            if($params['status'] == 2){
                $query->where('a.kesimpulan','Tidak Layak');
            }

         $data = [
             'item'         => $query->get(),
             'title'        => 'LAPORAN HASIL ALTERNATIF KEPUTUSAN',
         ];
 
         $pdf = PDF::loadView('laporan.print.cetak_hasil_perhitungan', $data)->setPaper('a4', 'landscape');
         return $pdf->stream('laporan_hasil_perhitungan.pdf'); 
     }
  
}