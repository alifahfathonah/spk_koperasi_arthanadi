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
    protected $semester = [
        '1' => 'Ganjil',
        '2' => 'Genap',
    ];

    protected $kelas = [
        'VII A' => 'VII A',
        'VII B' => 'VII B',
        'VII C' => 'VII C',
        'VIII A'  => 'VIII A',
        'VIII B'  => 'VIII B',
        'VIII C' => 'VIII C',
        'IX A'  => 'IX A',
        'IX B' => 'IX B',
        'IX C' => 'IX C',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function pembayaran()
   {
            $item = [
                'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                'date_end'   => Carbon::now()->endOfMonth()->toDateString()
            ];

            $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Pembayaran SPP',
                'url_print'         => 'laporan/pembayaran/print'
            );

            return view('laporan.form.pembayaran', $data);

    }

    public function print_pembayaran(Request $request)
    {
        $params = $request->input('f');
        // ======== Jika Siswa ==========
        if(Helpers::getJabatan() == 'Siswa'):
            $siswa = DB::table('tb_siswa')
                    ->where('id_user', Helpers::getId())
                    ->first();
            $pembayaran = DB::table('tb_pembayaran as a')
                            ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                            ->join('tb_siswa as c','c.nis','=','a.nis')
                            ->join('tb_user as d','d.id','=','c.id_user')
                            ->whereBetween('b.tgl_pembayaran',[$params['date_start'],$params['date_end']])
                            ->where([
                                'c.id_user' => Helpers::getId(),
                                'b.batal' => 0
                            ])
                            ->select(
                                'b.tgl_pembayaran',
                                'b.nominal',
                                'b.semester',
                                'b.bulan'
                            )
                            ->orderBy('b.bulan', 'asc')
                            ->orderBy('b.tgl_pembayaran', 'asc')
                            ->get();
            

            $data = [
                'params'       => (object) $params,
                'siswa'        => $siswa,
                'item'         => $pembayaran,
                'title'        => 'Laporan Pembayaran SPP',
            ];

            $pdf = PDF::loadView('laporan.print.cetak_pembayaran_siswa', $data, $params)->setPaper('a4', 'landscape');
            return $pdf->stream($params['date_start'].$params['date_end'].'laporan_pembayaran_siswa.pdf'); 
        else:
                $pembayaran = DB::table('tb_pembayaran as a')
                                ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                                ->join('tb_siswa as c','c.nis','=','a.nis')
                                ->whereBetween('b.tgl_pembayaran',[$params['date_start'],$params['date_end']])
                                ->where('b.batal', 0)
                                ->select(
                                    'b.tgl_pembayaran',
                                    'b.nominal',
                                    'c.nis',
                                    'c.nama',
                                    'c.kelas',
                                    'c.jurusan',
                                    'c.jenis_kelamin'
                                )
                                ->orderBy( 'b.tgl_pembayaran', 'asc')
                                ->get();
    
                $data = [
                    'params'       => (object) $params,
                    'item'         => $pembayaran,
                    'title'        => 'Laporan Pembayaran SPP',
                ];
    
                $pdf = PDF::loadView('laporan.print.cetak_pembayaran', $data, $params)->setPaper('a4', 'landscape');
                return $pdf->stream($params['date_start'].$params['date_end'].'laporan_pembayaran.pdf'); 
        endif;
    }

    public function rekapitulasi()
    {
             $item = [
                 'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                 'date_end'   => Carbon::now()->endOfMonth()->toDateString(),
             ];
 
             $data = array(
                 'item'              => (object) $item,
                 'title'             => 'Laporan Rekapitulasi',
                 'url_print'         => 'laporan/rekapitulasi/print',
                 'option_semester'   => $this->semester,
                 'option_kelas'             => $this->kelas
             );
 
             return view('laporan.form.rekapitulasi', $data);
 
     }
 
    //  private function get_nominal_by_bulan($nis, $bulan, $date_start, $date_end, $semester, $kelas)
    //  {
    //     $query = DB::table('tb_pembayaran as a')
    //                 ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
    //                 ->join('tb_siswa as c','c.nis','=','a.nis')
    //                 ->whereBetween('b.tgl_pembayaran',[$date_start, $date_end])
    //                 ->where([
    //                     'b.nis' => $nis,
    //                     'b.bulan' => $bulan,
    //                     'b.semester' => $semester,
    //                     'b.kelas' =>  $kelas
    //                 ])
    //                 ->select('b.nominal')
    //                 ->first();

    //     return (!empty(@$query->nominal) || @$query->nominal > 0) ? @$query->nominal : 0;
    //  }

     private function get_nominal_by_bulan($nis, $bulan, $semester, $kelas)
     {
        $query = DB::table('tb_pembayaran as a')
                    ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                    ->join('tb_siswa as c','c.nis','=','a.nis')
                    ->where([
                        'b.nis' => $nis,
                        'b.bulan' => $bulan,
                        'b.semester' => $semester,
                        'b.kelas' =>  $kelas,
                        'b.batal' => 0
                    ])
                    ->select('b.nominal')
                    ->first();

        return (!empty(@$query->nominal) || @$query->nominal > 0) ? @$query->nominal : 0;
     }
     public function print_rekapitulasi(Request $request)
     {
         $params = $request->input('f');

         $query = DB::table('tb_pembayaran as a')
                        ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                        ->join('tb_siswa as c','c.nis','=','a.nis')
                        // ->whereBetween('b.tgl_pembayaran',[date('Y-m-01', strtotime($params['date_start'])), date('Y-m-t', strtotime($params['date_end']))])
                        ->where([
                            'b.semester' => $params['semester'],
                            'b.kelas' => $params['kelas'],
                            'b.batal' => 0
                        ])
                        ->select(
                            'c.nis',
                            'c.nama'
                        )
                        ->groupBy(
                            'c.nis',
                            'c.nama'
                        )
                        ->get();

        $collection = array();
        if($params['semester'] != 1):
            foreach($query as $row):
                $collection[] = [
                    'nis' => $row->nis,
                    'nama' => $row->nama,
                    'januari' => self::get_nominal_by_bulan($row->nis, 1, $params['semester'], $params['kelas']),
                    'pebruari' => self::get_nominal_by_bulan($row->nis, 2, $params['semester'], $params['kelas']),
                    'maret' => self::get_nominal_by_bulan($row->nis, 3,  $params['semester'], $params['kelas']),
                    'april' => self::get_nominal_by_bulan($row->nis, 4, $params['semester'], $params['kelas']),
                    'mei' => self::get_nominal_by_bulan($row->nis, 5, $params['semester'], $params['kelas']),
                    'juni' => self::get_nominal_by_bulan($row->nis, 6, $params['semester'], $params['kelas']),
                ];
            endforeach;
        else:
            foreach($query as $row):
                $collection[] = [
                    'nis' => $row->nis,
                    'nama' => $row->nama,
                    'juli' => self::get_nominal_by_bulan($row->nis, 7,  $params['semester'], $params['kelas']),
                    'agustus' => self::get_nominal_by_bulan($row->nis, 8,  $params['semester'], $params['kelas']),
                    'september' => self::get_nominal_by_bulan($row->nis, 9,  $params['semester'], $params['kelas']),
                    'oktober' => self::get_nominal_by_bulan($row->nis, 10,  $params['semester'], $params['kelas']),
                    'november' => self::get_nominal_by_bulan($row->nis, 11, $params['semester'], $params['kelas']),
                    'desember' => self::get_nominal_by_bulan($row->nis, 12,  $params['semester'], $params['kelas']),
                ];
            endforeach;
        endif;

        // date('Y-m-01', strtotime($params['date_start'])), date('Y-m-t', strtotime($params['date_end'])),

        // return response()->json($collection, 200);exit;
         $data = [
             'params'            => (object) $params,
             'title'             => 'Laporan Rekapitulasi',
             'item'              => (object) $collection
         ];

         if($params['semester'] != 1):
            $pdf = PDF::loadView('laporan.print.cetak_rekapitulasi_I', $data, $params)->setPaper('a4', 'landscape');
         else:
            $pdf = PDF::loadView('laporan.print.cetak_rekapitulasi_II', $data, $params)->setPaper('a4', 'landscape');
         endif;
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_rekapitulasi.pdf'); 
     }

     public function tunggakan()
     {
              $item = [
                  'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                  'date_end'   => Carbon::now()->endOfMonth()->toDateString()
              ];
  
              $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Tunggakan SPP',
                'url_print'         => 'laporan/tunggakan/print',
                'option_semester'   => $this->semester,
                'option_kelas'      => $this->kelas
            );
  
            return view('laporan.form.tunggakan', $data);
      }
  
      public function print_tunggakan(Request $request)
      {
            $params = $request->input('f');
            $query = DB::table('tb_pembayaran as a')
                        ->join('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                        ->join('tb_siswa as c','c.nis','=','a.nis')
                        // ->whereBetween('b.tgl_pembayaran',[date('Y-m-01', strtotime($params['date_start'])),date('Y-m-t', strtotime($params['date_end']))])
                        ->where([
                            'b.semester' => $params['semester'],
                            'b.kelas' => $params['kelas'],
                            'b.batal' => 0
                        ])
                        ->select(
                            'c.nis',
                            'c.nama'
                        )
                        ->groupBy(
                            'c.nis',
                            'c.nama'
                        )
                        ->get();

        $collection = array();
        if($params['semester'] != 1):
            foreach($query as $row):
                $collection[] = [
                    'nis' => $row->nis,
                    'nama' => $row->nama,
                    'januari' => self::get_nominal_by_bulan($row->nis, 1,  $params['semester'], $params['kelas']),
                    'pebruari' => self::get_nominal_by_bulan($row->nis, 2, $params['semester'], $params['kelas']),
                    'maret' => self::get_nominal_by_bulan($row->nis, 3, $params['semester'], $params['kelas']),
                    'april' => self::get_nominal_by_bulan($row->nis, 4, $params['semester'], $params['kelas']),
                    'mei' => self::get_nominal_by_bulan($row->nis, 5, $params['semester'], $params['kelas']),
                    'juni' => self::get_nominal_by_bulan($row->nis, 6, $params['semester'], $params['kelas']),
                ];
            endforeach;
        else:
            foreach($query as $row):
                $collection[] = [
                    'nis' => $row->nis,
                    'nama' => $row->nama,
                    'juli' => self::get_nominal_by_bulan($row->nis, 7, $params['semester'], $params['kelas']),
                    'agustus' => self::get_nominal_by_bulan($row->nis, 8, $params['semester'], $params['kelas']),
                    'september' => self::get_nominal_by_bulan($row->nis, 9, $params['semester'], $params['kelas']),
                    'oktober' => self::get_nominal_by_bulan($row->nis, 10, $params['semester'], $params['kelas']),
                    'november' => self::get_nominal_by_bulan($row->nis, 11,  $params['semester'], $params['kelas']),
                    'desember' => self::get_nominal_by_bulan($row->nis, 12,  $params['semester'], $params['kelas']),
                ];
            endforeach;
        endif;


          $data = [
              'params'            => (object) $params,
              'item'              => (empty($collection)) ? array() : $collection,
              'title'             => 'Laporan Tunggakan SPP',
          ];


        if($params['semester'] != 1):
            $pdf = PDF::loadView('laporan.print.cetak_tunggakan_I', $data, $params)->setPaper('a4', 'landscape');
         else:
            $pdf = PDF::loadView('laporan.print.cetak_tunggakan_II', $data, $params)->setPaper('a4', 'landscape');
         endif;
         return $pdf->stream($params['date_start'].$params['date_end'].'laporan_tunggakan_spp.pdf'); 
      }

      public function rkas()
      {
        $periode = [
            ['id' => '2020/2021','desc' => '2020/2021'],
            ['id' => '2021/2022','desc' => '2021/2022'],
            ['id' => '2022/2023','desc' => '2022/2023'],  
        ];

        $data = array(
            'title'             => 'Laporan RKAS',
            'url_print'         => 'laporan/rkas/print',
            'periode'           => $periode
        );

        return view('laporan.form.rkas', $data);
   
       }
   
       public function print_rkas(Request $request)
       {
           $params = $request->input('f');
            $query = DB::table('tb_rkas')
                    ->select('*')
                    ->where('tahun_ajaran', $params['periode'])
                    ->get();

            // return response()->json($query, 200);exit;
           $data = [
               'params'            => (object) $params,
               'title'             => 'Laporan RKAS',
               'item'              => $query
           ]; 

           $pdf = PDF::loadView('laporan.print.cetak_rkas', $data, $params)->setPaper('a4', 'landscape');
           return $pdf->stream($params['periode'].'laporan_rkas.pdf'); 
       }

      public function pengeluaran()
      {
        $item = [
            'date_start' => Carbon::now()->startOfMonth()->toDateString(),
            'date_end'   => Carbon::now()->endOfMonth()->toDateString()
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Laporan Pengeluaran Kas',
            'url_print'         => 'laporan/pengeluaran/print'
        );

        return view('laporan.form.pengeluaran', $data);
   
       }
   
       public function print_pengeluaran(Request $request)
       {
            $params = $request->input('f');
            $query = DB::table('tb_pengeluaran as a')
                    ->leftjoin('tb_rkas as b','b.id','=','a.akun_rkas')
                    ->leftjoin('tb_akun as c','c.id','=','b.akun_id')
                    ->select('a.*','c.kode_akun','c.nama_akun')
                    ->whereBetween('a.tanggal',[$params['date_start'],$params['date_end']])
                    ->where('a.status_batal', 0)
                    ->orderBy('a.tanggal', 'ASC')
                    ->get();
            // return response()->json($query, 200);exit;

            $data = [
                'params'  => (object) $params,
                'item'    => $query,
                'title'   => 'Laporan Pengeluaran Kas',
            ];
           
           $pdf = PDF::loadView('laporan.print.cetak_pengeluaran', $data, $params)->setPaper('a4', 'portait');
           return $pdf->stream($params['date_start'].$params['date_end'].'laporan_pengeluaran.pdf'); 
       }

       public function lpj()
       {
                $periode = [
                    ['id' => '2020/2021','desc' => '2020/2021'],
                    ['id' => '2021/2022','desc' => '2021/2022'],
                    ['id' => '2022/2023','desc' => '2022/2023'],  
                ];
    
                $data = array(
                    'item'                  => '',
                    'periode'   => $periode,
                    'title'                 => 'Laporan Pertanggung Jawaban',
                    'url_print'             => 'laporan/lpj/print'
                );
    
                return view('laporan.form.lpj', $data);
    
        }

        private function get_pengeluaran_by_rkas($id)
        {
            $query = DB::table('tb_pengeluaran')
                    ->select(DB::raw("SUM(total) as pengeluaran"))
                    ->where('akun_rkas', $id)
                    ->where('status_batal', 0)
                    ->first();

            return $query->pengeluaran;
        }
    
        public function print_lpj(Request $request, $id_kk = 13)
        {
            $params         = $request->input('f');
            $query = DB::table('tb_rkas as a')
                    ->select('a.*')
                    ->where('a.tahun_ajaran', $params['periode'] )
                    ->get();

        $collection = array();            
        foreach($query as $row):
            $collection[] = [
                'kode_akun' => $row->id_rkas,
                'keterangan' => $row->keterangan,
                'anggaran' => $row->nominal,
                'pengeluaran' => self::get_pengeluaran_by_rkas($row->id)
            ];
        endforeach;

            $data = [
                'params'      => (object) $params,
                'item'        => $collection,
                'title'       => 'Laporan Pertanggung Jawaban',
            ];


            $pdf = PDF::loadView('laporan.print.cetak_lpj', $data, $params)->setPaper('a4', 'portait');
            return $pdf->stream($params['periode'].'laporan_lpj.pdf'); 
        }

        public function arus_kas()
        {
            $item = [
                'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                'date_end'   => Carbon::now()->endOfMonth()->toDateString()
            ];
     
            $data = array(
                'item'              => (object) $item,
                'title'             => 'Laporan Arus Kas',
                'url_print'         => 'laporan/arus-kas/print'
            );

            return view('laporan.form.arus_kas', $data);
     
         }
     
         public function print_arus_kas(Request $request)
         {
            $params         = $request->input('f');

            $dateBeforeFirst = $params['date_start'].'first day of last month';
            $dtFirst = date_create($dateBeforeFirst);
            $dateBeforeLast = $params['date_start'].'last day of last month';
            $dtLast = date_create($dateBeforeLast);

            $penerimaan_dari_spp = DB::table('tb_pembayaran as a')
                                ->join('tb_pembayaran_detail as b','a.id_pembayaran','=','b.id_pembayaran')
                                ->whereBetween('b.tgl_pembayaran',[$params['date_start'],$params['date_end']])
                                ->where('b.batal', 0)
                                ->select(DB::raw('SUM(b.nominal) AS total'))
                                ->first();
            $pengeluaran = DB::table('tb_pengeluaran as a')
                                ->join('tb_pengeluaran_detail as b','a.id_pengeluaran','=','b.id_pengeluaran')
                                ->join('tb_rkas as c','c.id','=','a.akun_rkas')
                                ->join('tb_akun as d','d.id','=','a.akun_id')
                                ->whereBetween('a.tanggal',[$params['date_start'],$params['date_end']])
                                ->where('a.status_batal', 0)
                                ->select('d.nama_akun', DB::raw('SUM(b.nominal) AS total'))
                                ->groupBy('d.nama_akun')
                                ->get();

            $penerimaan_dari_spp_before = DB::table('tb_pembayaran as a')
                            ->join('tb_pembayaran_detail as b','a.id_pembayaran','=','b.id_pembayaran')
                            ->whereBetween('b.tgl_pembayaran',[$dtFirst->format('Y-m-d'), $dtLast->format('Y-m-d')])
                            ->where('b.batal', 0)
                            ->select(DB::raw('SUM(b.nominal) AS total'))
                            ->first();
            $pengeluaran_before = DB::table('tb_pengeluaran as a')
                            ->join('tb_pengeluaran_detail as b','a.id_pengeluaran','=','b.id_pengeluaran')
                            ->join('tb_rkas as c','c.id','=','a.akun_rkas')
                            ->join('tb_akun as d','d.id','=','a.akun_id')
                            ->whereBetween('a.tanggal',[$dtFirst->format('Y-m-d'), $dtLast->format('Y-m-d')])
                            ->where('a.status_batal', 0)
                            ->select('d.nama_akun', DB::raw('SUM(b.nominal) AS total'))
                            ->groupBy('d.nama_akun')
                            ->get();
                
            

            $totalPengeluaran = 0;
            foreach($pengeluaran_before as $row){
                $totalPengeluaran += $row->total;
            }

             $data = [
                 'params'            => (object) $params,
                 'collection'        => '',
                 'title'             => 'Laporan Arus Kas',
                 'penerimaan_dari_spp' => $penerimaan_dari_spp,
                 'pengeluaran'  => $pengeluaran,
                 'saldo_kas_bulan_lalu' => $penerimaan_dari_spp_before->total - $totalPengeluaran
             ];
 
             $pdf = PDF::loadView('laporan.print.cetak_arus_kas', $data, $params)->setPaper('a4', 'portait');
             return $pdf->stream($params['date_start'].$params['date_end'].'laporan_arus_kas.pdf'); 
         }

         public function perubahan_modal()
         {
             $item = [
                 'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                 'date_end'   => Carbon::now()->endOfMonth()->toDateString()
             ];
      
             $data = array(
                 'item'              => (object) $item,
                 'title'             => 'Laporan Perubahan Anggaran',
                 'url_print'         => 'laporan/perubahan-modal/print'
             );
 
             return view('laporan.form.perubahan_modal', $data);
      
          }

               
         public function print_perubahan_modal(Request $request)
         {
            $params                 = $request->input('f');
            $anggaran               = DB::table('tb_rkas as a')
                                        ->whereBetween('a.tanggal',[$params['date_start'],$params['date_end']])
                                        ->select(DB::raw('SUM(a.nominal) AS total'))
                                        ->first()->total;
                
            $tambahan_modal_disetor = DB::table('tb_pembayaran as a')
                                        ->join('tb_pembayaran_detail as b','a.id_pembayaran','=','b.id_pembayaran')
                                        ->whereBetween('b.tgl_pembayaran',[$params['date_start'],$params['date_end']])
                                        ->where('b.batal', 0)
                                        ->select(DB::raw('SUM(b.nominal) AS total'))
                                        ->first()->total;

            $deviden                = DB::table('tb_jurnal as a')
                                        ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                                        ->whereBetween('a.tanggal',[$params['date_start'],$params['date_end']])
                                        ->where('b.kode_akun', '3004')
                                        ->select(DB::raw('SUM(b.debet) AS total'))
                                        ->first()->total;
            
            $laba_ditahan = 0;
            $laba_ditahan_periode_sekarang = 0;
            $penghasilan_lain = 0;

             $data = [
                 'params'                   => (object) $params,
                 'title'                    => 'Laporan Perubahan Anggaran',
                 'anggaran'                 => $anggaran,
                 'tambahan_modal_disetor'   => $tambahan_modal_disetor,
                 'deviden'                  => $deviden,
                 'laba_ditahan'             => $laba_ditahan,
                 'laba_ditahan_periode_sekarang' => $laba_ditahan_periode_sekarang,
                 'penghasilan_lain'         => $penghasilan_lain
             ];
 
             $pdf = PDF::loadView('laporan.print.cetak_perubahan_modal', $data, $params)->setPaper('a4', 'portait');
             return $pdf->stream($params['date_start'].$params['date_end'].'laporan_perubahan_modal.pdf'); 
         }

         public function neraca()
         {
             $item = [
                 'date_start' => Carbon::now()->startOfMonth()->toDateString(),
                 'date_end'   => Carbon::now()->endOfMonth()->toDateString()
             ];
      
             $data = array(
                 'item'              => (object) $item,
                 'title'             => 'Laporan Neraca',
                 'url_print'         => 'laporan/neraca/print'
             );
 
             return view('laporan.form.neraca', $data);
      
          }

          private function _get_summary($kode_akun, $date_start, $date_end)
          {
               $jurnal = DB::table('tb_jurnal as a')
                       ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                       ->leftjoin('tb_akun as c','c.kode_akun','=','b.kode_akun')
                       ->whereBetween('a.tanggal', [$date_start, $date_end])
                       ->select([
                           DB::raw('SUM(b.debet) AS debet'),
                           DB::raw('SUM(b.kredit) AS kredit'),
                       ])
                       ->where([
                           'b.kode_akun' => $kode_akun
                       ])->first();
   
               $pembayaran = DB::table('tb_pembayaran as a')
                       ->leftjoin('tb_pembayaran_detail as b','b.id_pembayaran','=','a.id_pembayaran')
                       ->whereBetween('b.tgl_pembayaran', [$date_start, $date_end])
                       ->where('b.batal', 0)
                       ->select([
                           DB::raw('SUM(b.nominal) AS total')
                       ])->first();

                $rkas = DB::table('tb_rkas')
                       ->whereBetween('tanggal', [$date_start, $date_end])
                       ->select([
                           DB::raw('SUM(nominal) AS total')
                       ])->first();
               
 
   
           
           return ($jurnal->debet - $jurnal->kredit) +  $pembayaran->total + $rkas->total;
          }
   
          
          public function print_neraca(Request $request)
         {
            $params = $request->input('f');
            // $aktiva = DB::table('tb_akun')
            //             ->select('kode_akun','nama_akun','kelompok')
            //             ->where([
            //                 'golongan' => 'Aktiva'
            //             ])
            //             ->orderBy('kode_akun','asc')
            //             ->get();

            // $passiva = DB::table('tb_akun')
            //             ->select('kode_akun','nama_akun','kelompok')
            //             ->whereIn('golongan', ['Hutang','Modal'])
            //             ->orderBy('kode_akun','asc')
            //             ->get();

            // $collection_aktiva = [];
            // foreach($aktiva as $akt):
            //     $collection_aktiva = [
            //         'kode_akun' => $akt->kode_akun,
            //         'nama_akun' => $akt->nama_akun,
            //         'nilai' => self::_get_summary($akt->kode_akun, $params['date_start'],$params['date_end']),
            //     ];

            //     $data_collect_aktiva[$akt->kelompok][] = $collection_aktiva;

            // endforeach;

            // // return response()->json($data_collect_aktiva, 200);exit;

        

            // $collection_passiva = [];
            // foreach($passiva as $pass):
            //     $collection_passiva = [
            //         'kode_akun' => $pass->kode_akun,
            //         'nama_akun' => $pass->nama_akun,
            //         'nilai' => self::_get_summary($pass->kode_akun, $params['date_start'],$params['date_end']),
            //     ];

            //     $data_collect_passiva[$pass->kelompok][] = $collection_passiva;

            // endforeach;

            $aset_tetap = DB::table('tb_akun')
                        ->select([
                            DB::raw('SUM(saldo_awal) AS total')
                        ])
                        ->whereIn('kode_akun',['1021','1023'])->first();

            $akumulasi_penyusutan =  DB::table('tb_jurnal as a')
                                ->join('tb_detail_jurnal as b','a.id_jurnal','=','b.id_jurnal')
                                ->leftjoin('tb_akun as c','c.kode_akun','=','b.kode_akun')
                                ->whereBetween('a.tanggal', [$params['date_start'],$params['date_end']])
                                ->select([
                                    DB::raw('SUM(b.kredit) AS kredit'),
                                    DB::raw('SUM(b.debet) AS debet'),
                                ])
                                ->whereIn(
                                    'b.kode_akun', ['1022','1024']
                                )->first();

            $utang_gaji = DB::table('tb_akun as a')
                            ->join('tb_rkas as b','a.id','=','b.akun_id')
                            ->select([
                                DB::raw('SUM(b.nominal) AS total')
                            ])
                            ->whereBetween('b.tanggal', [$params['date_start'],$params['date_end']])
                            ->whereIn('kode_akun',['6006'])->first();

            $utang_dibayar = DB::table('tb_pengeluaran as a')
                            ->join('tb_pengeluaran_detail as b','a.id_pengeluaran','=','b.id_pengeluaran')
                            ->leftjoin('tb_akun as c','c.id','=','b.akun_id')
                            ->select([
                                DB::raw('SUM(b.nominal) AS total')
                            ])
                            ->whereBetween('a.tanggal', [$params['date_start'],$params['date_end']])
                            ->where('a.status_batal', 0)
                            ->whereIn(
                                'c.kode_akun', ['6006']
                            )->first();

            $data = [
                'params'    => (object) $params,
                // 'aktiva'    => $data_collect_aktiva,
                // 'passiva'    => $data_collect_passiva,
                'kas' => self::_get_summary('1002', $params['date_start'],$params['date_end']),
                'aktiva_tetap' => $aset_tetap->total,
                'akumulasi_penyusutan' => $akumulasi_penyusutan->kredit,
                'utang_gaji' => $utang_gaji->total - $utang_dibayar->total,
                'title'     => 'Laporan Neraca',
            ];
            
            $pdf = PDF::loadView('laporan.print.cetak_neraca', $data, $params)->setPaper('a4', 'landscape');
            return $pdf->stream($params['date_start'].$params['date_end'].'laporan_neraca.pdf');
         }

  
}