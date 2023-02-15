<?php

namespace App\Http\Controllers;

use App\Http\Model\Alternatif_m;
use App\Http\Model\Hasil_fucom_smart_m;
use App\Http\Model\Hasil_normalisasi_m;
use App\Http\Model\Pengajuan_m;
use Illuminate\Http\Request;
use App\Http\Model\Proses_spk_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class ProsesSpkController extends Controller
{
    protected $model;
    protected $model_pengajuan;
    protected $model_hasil_normalisasi;
    protected $model_hasil;
    public function __construct(
            Proses_spk_m $model, 
            Pengajuan_m $model_pengajuan, 
            Hasil_normalisasi_m $model_hasil_normalisasi,
            Hasil_fucom_smart_m $model_hasil
        )
    {
        $this->model = $model;
        $this->model_pengajuan = $model_pengajuan;
        $this->model_hasil_normalisasi = $model_hasil_normalisasi;
        $this->model_hasil = $model_hasil;
        $this->nameroutes = 'proses-spk';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
   {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Proses SPK',
            'breadcrumb'        => 'Proses SPK',
            'urlDatatables'     => 'proses-spk/datatables',
            'idDatatables'      => 'dt_proses_spk'
        );
        return view('proses_spk.datatable',$data);
    }

    public function proses_normalisasi(Request $request)
    {
        #jika form sumbit
        if($request->post())
        {
            $detail = $request->post('details');
            if(empty($detail))
            {
                $response = [
                    'message'   => 'Tidak terdapat data pengajuan!',
                    'status'    => 'error',
                    'code'      => 500,
                ];
                return Response::json($response);
            }

            foreach($detail as $det){
                $C1[] = $det['C1'];
                $C2[] = $det['C2'];
                $C3[] = $det['C3'];
                $C4[] = $det['C4'];
                $C5[] = $det['C5'];
                $C6[] = $det['C6'];
            }
            $C1_min = min( $C1);
            $C1_max = max( $C1);
            $C2_min = min( $C2);
            $C2_max = max( $C2);
            $C3_min = min( $C3);
            $C3_max = max( $C3);
            $C4_min = min( $C4);
            $C4_max = max( $C4);
            $C5_min = min( $C5);
            $C5_max = max( $C5);
            $C6_min = min( $C6);
            $C6_max = max( $C6);

            $data_perhitungan = [];
            foreach($detail as $row){
                $data_perhitungan[] = [
                    'id_pengajuan' => $row['id_pengajuan'],
                    'alternatif' => $row['kode_alternatif'],
                    'c1' => round(100 * ($C1_max-$C1_min > 0 ? ($row['C1']-$C1_min) / ($C1_max-$C1_min) : 0),2),
                    'c2' => round(100 * ($C2_max-$C2_min > 0 ? ($row['C2']-$C2_min) / ($C2_max-$C2_min) : 0 ),2),
                    'c3' => round(100 * ($C3_max-$C3_min > 0 ? ($row['C3']-$C3_min) / ($C3_max-$C3_min) : 0 ),2),
                    'c4' => round(100 * ($C4_max-$row['C4'] > 0 ? ($C4_max-$row['C4']) / ($C4_max-$C4_min) : 0 ),2), #pengeluaran
                    'c5' => round(100 * ($C5_max-$C5_min > 0 ? ($row['C5']-$C5_min) / ($C5_max-$C5_min) : 0 ),2),
                    'c6' => round(100 * ($C6_max-$C6_min > 0 ? ($row['C6']-$C6_min) / ($C6_max-$C6_min) : 0 ),2),
                ];
            }

            dd($data_perhitungan);
            Hasil_normalisasi_m::query()->delete();
            $this->model_hasil_normalisasi->insert_data($data_perhitungan);
            $response = [
                'message'   => 'Proses normalisasi berhasil!',
                'status'    => 'success',
                'code'      => 200,
            ];
            return Response::json($response);
        }

    }

    public function normalisasi()
    {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Hasil Normalisasi Alternatif',
            'breadcrumb'        => 'Hasil Normalisasi Alternatif'
        );

        return view('proses_spk.normalisasi', $data);
    }

    public function proses_fucom_smart(Request $request)
    {
        #jika form sumbit
        if($request->post())
        {
            $detail = $request->post('details');
            if(empty($detail))
            {
                $response = [
                    'message'   => 'Tidak terdapat data pengajuan!',
                    'status'    => 'error',
                    'code'      => 500,
                ];
                return Response::json($response);
            }

            foreach($detail as $det){
                $hasil_fucom_smart[] = [
                    'id_pengajuan' => $det['id_pengajuan'],
                    'alternatif' => $det['alternatif'],
                    'c1' => round($det['c1'], 2) * bobot_kriteria('C1'),
                    'c2' => round($det['c2'], 2) * bobot_kriteria('C2'),
                    'c3' => round($det['c3'], 2) * bobot_kriteria('C3'),
                    'c4' => round($det['c4'], 2) * bobot_kriteria('C4'),
                    'c5' => round($det['c5'], 2) * bobot_kriteria('C5'),
                    'c6' => round($det['c6'], 2) * bobot_kriteria('C6')
                ];
            }

            foreach($hasil_fucom_smart as $key){
                Pengajuan_m::where(['id_pengajuan' => $key['id_pengajuan'], 'aktif' => 1])->update(['sudah_proses' => 1]);
                Hasil_normalisasi_m::query()->delete();
                $hitung_hasil = round($key['c1'] + $key['c2'] + $key['c3'] + $key['c4'] + $key['c5'] + $key['c6'], 2);

                $hasil_akhir[] = [
                    'id_pengajuan' => $key['id_pengajuan'],
                    'alternatif' => $key['alternatif'],
                    'c1' => round($key['c1'],2),
                    'c2' => round($key['c2'],2),
                    'c3' => round($key['c3'],2),
                    'c4' => round($key['c4'],2),
                    'c5' => round($key['c5'],2),
                    'c6' => round($key['c6'],2),
                    'hasil' => $hitung_hasil,
                    'kesimpulan' => ($hitung_hasil > 55) ? 'Layak' : 'Tidak Layak',
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
            $this->model_hasil->insert_data($hasil_akhir);
            
            $response = [
                'message'   => 'Proses perhitungan FUCOM-SMART berhasil!',
                'status'    => 'success',
                'code'      => 200,
            ];
            return Response::json($response);

        }
    }

    public function fucom_smart()
    {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Hasil Perhitungan FOCUM SMART',
            'breadcrumb'        => 'Hasil Perhitungan FOCUM SMART'
        );

        return view('proses_spk.fucom_smart', $data);
    }

    public function perangkingan()
    {
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Data Perangkingan',
            'breadcrumb'        => 'Perangkingan'
        );

        return view('proses_spk.perangkingan', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
            'pinjaman'                  => $this->model_pinjaman::get(),
        ];

        //jika form sumbit
        if($request->post())
        {
           //request dari view
           $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header, [
                'id_pinjaman' => [Rule::unique('tb_alternatif')->ignore($get_data->pinjaman_id, 'id_pinjaman')],
                'kode_alternatif' => [Rule::unique('tb_alternatif')->ignore($get_data->kode_alternatif, 'kode_alternatif')],
            ]);
           if ($validator->fails()) {
               $response = [
                   'message' => $validator->errors()->first(),
                   'status' => 'error',
                   'code' => 500,
               ];
               return Response::json($response);
           }

            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data($header, $id);
                DB::commit();

                $response = [
                    "message" => 'Data alternatif berhasil diperbarui',
                    'status' => 'success',
                    'code' => 200,
                ];
           
            } catch (\Exception $e) {
                DB::rollback();
                $response = [
                    "message" => $e->getMessage(),
                    'status' => 'error',
                    'code' => 500,
                    
                ];
            }
            return Response::json($response); 
        }
        
        return view('alternatif.form', $data);
    }

    public function view($id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
        ];

        return view('alternatif.view', $data);
    }

    public function reset_hasil()
    {
        Hasil_normalisasi_m::query()->delete();
        Hasil_fucom_smart_m::query()->delete();
        Pengajuan_m::query()->update(['sudah_proses' => 0]);
        
        $response = [
            'message'   => 'Berhasil melakukan reset hasil perhitungan!',
            'status'    => 'success',
            'code'      => 200,
        ];
        return Response::json($response);

    }


    public function datatables_collection()
    {
        $params = request()->all();
        $data = $this->model->get_all($params);
        return Datatables::of($data)->make(true);
    }

    public function datatables_collection_normalisasi()
    {
        $data = $this->model_hasil_normalisasi->get_all();
        return Datatables::of($data)->make(true);
    }

    public function datatables_collection_fucom_smart()
    {
        $params = request()->all();
        $data = $this->model_hasil->get_all($params);
        return Datatables::of($data)->make(true);
    }

}
