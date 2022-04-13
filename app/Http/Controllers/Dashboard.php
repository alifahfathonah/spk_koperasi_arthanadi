<?php

namespace App\Http\Controllers;
use App\Http\Model\Tahun_ajaran_m;
use App\Http\Model\Pembayaran_m;
use App\Http\Model\Keuangan_m;
use App\Http\Model\Kelas_m;
use Illuminate\Http\Request;
use DataTables;
use Response;
use DB;
use Helpers;

class Dashboard extends Controller
{
    protected $bulan = [
        ['id' => '1', 'desc' => 'Januari'],
        ['id' => '2', 'desc' => 'Februari'],
        ['id' => '3', 'desc' => 'Maret'],
        ['id' => '4', 'desc' => 'April'],
        ['id' => '5', 'desc' => 'Mei'],
        ['id' => '6', 'desc' => 'Juni'],
        ['id' => '7', 'desc' => 'Juli'],
        ['id' => '8', 'desc' => 'Agustus'],
        ['id' => '9', 'desc' => 'September'],
        ['id' => '10', 'desc' => 'Oktober'],
        ['id' => '11', 'desc' => 'November'],
        ['id' => '12', 'desc' => 'Desember'],
    ];

    public function __construct()
    {
        $this->model_pembayaran = New Pembayaran_m;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date = date('Y-m-d');
        $data = [
            'title' => 'Dashboard',
            'pemasukan_hari_ini' => DB::table('tb_pembayaran_detail')
                                    ->select(DB::raw('sum(nominal) as total'))
                                    ->where('tgl_pembayaran', $date)
                                    ->where('batal', 0)
                                    ->first(),
            'pemasukan_bulan_ini' => DB::table('tb_pembayaran_detail')
                                    ->select(DB::raw('sum(nominal) as total'))
                                    ->where(DB::raw('MONTH(tgl_pembayaran)'), date('m', strtotime($date)))
                                    ->where('batal', 0)
                                    ->first(),
            'pemasukan_tahun_ini' => DB::table('tb_pembayaran_detail')
                                    ->select(DB::raw('sum(nominal) as total'))
                                    ->where(DB::raw('YEAR(tgl_pembayaran)'), date('Y', strtotime($date)))
                                    ->where('batal', 0)
                                    ->first(),
            'pemasukan_total'     => DB::table('tb_pembayaran_detail')
                                    ->where('batal', 0)
                                    ->select(DB::raw('sum(nominal) as total'))
                                    ->first(),

        ];
        if(Helpers::getJabatan() == 'Siswa')
        {
            return view('dashboard.dashboard_siswa', $data);
        }else{ 
            return view('dashboard.dashboard', $data);
        }

    }

    public function dashboard_master()
    {
        $data = [
            'title' => 'Dashboard Data Master',
        ];
        return view('dashboard.dashboard_master', $data);
    }
    public function dashboard_laporan()
    {
        $data = [
            'title' => 'Dashboard Laporan',
        ];
        return view('dashboard.dashboard_laporan', $data);
    }


    public function info_siswa()
    {
        $data = [
            'option_tahun_ajaran' => $this->model_tahun_ajaran->get_all(),
            'bulan' => $this->bulan,
            'option_kelas' => $this->model_kelas->get_all()
        ];
        return view('dashboard.modal.info_siswa', $data);
    }

    public function info_pemasukan()
    {
        $data = [
            'option_tahun_ajaran' => $this->model_tahun_ajaran->get_all(),
            'bulan' => $this->bulan,
            'option_kelas' => $this->model_kelas->get_all()
        ];
        return view('dashboard.modal.info_pemasukan', $data);
    }

    public function info_pengeluaran()
    {
        $data = [
            'option_tahun_ajaran' => $this->model_tahun_ajaran->get_all(),
            'bulan' => $this->bulan,
            'option_kelas' => $this->model_kelas->get_all()
        ];
        return view('dashboard.modal.info_pengeluaran', $data);
    }

    public function datatables_pembayaran_spp()
    {
        $params = request()->all();
        $data = $this->model_pembayaran->get_pembayaran_spp($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_pembayaran_gedung()
    {
        $params = request()->all();
        $data = $this->model_pembayaran->get_pembayaran_gedung($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_pemasukan_spp()
    {
        $params = request()->all();
        $data = $this->model_pembayaran->get_pemasukan_spp($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_pemasukan_gedung()
    {
        $params = request()->all();
        $data = $this->model_pembayaran->get_pemasukan_gedung($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_pemasukan_lainnya()
    {
        $params = request()->all();
        $data = $this->model_keuangan->get_pemasukan_lainnya($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_pengeluaran()
    {
        $params = request()->all();
        $data = $this->model_keuangan->get_pengeluaran($params);
        return Datatables::of($data)->make(true);
    }


    public function chart(Request $request)
    {
        $params = $request->post('header');
        $pemasukan = DB::table('tb_transaksi as a')
                    ->select(DB::raw('sum(a.total) as total'), DB::raw('MONTH(a.tanggal) month'))
                    ->groupby('month')
                    ->where(DB::raw('YEAR(a.tanggal)'),$params['year'])
                    ->get();

        $pembayaran = DB::table('tb_keuangan as a')
                    ->select(DB::raw('sum(a.nominal) as total'), DB::raw('MONTH(a.tanggal) month'))
                    ->groupby('month')
                    ->where(DB::raw('YEAR(a.tanggal)'),$params['year'])
                    ->where('no_transaksi', 'like', '%PMK%')
                    ->get();


        $pengeluaran = DB::table('tb_keuangan as a')
                    ->select(DB::raw('sum(a.nominal) as total'), DB::raw('MONTH(a.tanggal) month'))
                    ->groupby('month')
                    ->where(DB::raw('YEAR(a.tanggal)'),$params['year'])
                    ->where('no_transaksi', 'like', '%PNL%')
                    ->get();

        $months = (object) array(
            ['id' => 1,'bulan' => 'Januari'], 
            ['id' => 2,'bulan' => 'Februari'], 
            ['id' => 3,'bulan' => 'Maret'], 
            ['id' => 4,'bulan' => 'April'], 
            ['id' => 5,'bulan' => 'Mei'], 
            ['id' => 6,'bulan' => 'Juni'], 
            ['id' => 7,'bulan' => 'Juli'], 
            ['id' => 8,'bulan' => 'Agustus'], 
            ['id' => 9,'bulan' => 'September'], 
            ['id' => 10,'bulan' => 'Oktober'], 
            ['id' => 11,'bulan' => 'November'], 
            ['id' => 12,'bulan' => 'Desember'], 
        );

        foreach($months as $bln):
                foreach($pemasukan as $pmb):
                    foreach($pengeluaran as $pnj):
                        foreach($pembayaran as $bayar):
                        if($bln['id'] == $pmb->month && $bln['id'] == $pnj->month && $bln['id'] == $bayar->month):
                            $dataGrafik = [
                                'Bulan' => $bln['bulan'],
                                'Pemasukan' => $pmb->total + $bayar->total,
                                'Pengeluaran' => $pnj->total
                            ];

                            $grafik[] = $dataGrafik;
                        endif;
                        endforeach;
                    endforeach;
            endforeach;
        endforeach;

        if(!empty($grafik)):
            $response = array(
                "data" => $grafik,
                "status" => "success",
                "message" => 'Grafik',
                "code" => "200",
            );
        else:
            foreach($months as $bln):
                            $dataGrafikEmpty = [
                                'Bulan' => $bln['bulan'],
                                'Pemasukan' => 0,
                                'Pengeluaran' => 0
                            ];

                            $grafikEmpty[] = $dataGrafikEmpty;
            endforeach;

            $response = array(
                "data" => $grafikEmpty,
                "status" => "success",
                "message" => 'Grafif',
                "code" => "200",
            );
        endif;
        return Response::json($response);
    }

    
}
