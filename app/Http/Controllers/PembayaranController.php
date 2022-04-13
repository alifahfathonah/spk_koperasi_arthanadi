<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Pembayaran_m;
use App\Http\Model\Pembayaran_detail_m;
use App\Http\Model\Siswa_m;
use DataTables;
use Response;
use DB;
use Helpers;
use Validator;
use Illuminate\Validation\Rule;
use PDF;

class PembayaranController extends Controller
{
    protected $nameroutes = 'pembayaran-spp';
    protected $bulan = [
        '1' => 'Januari',
        '2' => 'Februari',
        '3' => 'Maret',
        '4' => 'April',
        '5' => 'Mei',
        '6' => 'Juni',
        '7' => 'Juli',
        '8' => 'Agustus',
        '9' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    protected $semester = [
        '1' => 'Ganjil',
        '2' => 'Genap',
    ];

    public function __construct()
    {
        $this->model = New Pembayaran_m;
        $this->model_siswa = New Siswa_m;
        $this->model_detail = New Pembayaran_detail_m;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index(){
        $data = array(
            'nameroutes'        => $this->nameroutes,
            'title'             => 'Data Pembayaran',
            'breadcrumb'        => 'List Data Pembayaran',
            'headerModalTambah' => 'TAMBAH PEMBAYARAN',
            'headerModalEdit'   => 'UBAH PEMBAYARAN',
            'urlDatatables'     => 'pembayaran-spp/datatables',
            'idDatatables'      => 'dt_pembayaran',
        );
        return view('pembayaran.datatable',$data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create(Request $request)
    {
        $item = [
            'id_pembayaran'     => $this->model->gen_code('PMB'),
            'tgl_pembayaran'    => date('Y-m-d'),
            'nominal'           => 0,
        ];

        $data = [
            'item'              => (object) $item,
            'title'             => 'Buat Pembayaran Baru',
            'breadcrumb'        => 'Data Pembayaran',
            'is_edit'           => FALSE,
            'submit_url'        => url()->current(),
            'nameroutes'        => $this->nameroutes,
            'option_bulan'      => (object) $this->bulan,
            'option_semester'   => (object) $this->semester,
        ];
        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['id_pembayaran'] = $this->model->gen_code('PMB');

            $details = array_merge($item, $request->input('details'));
            $details['id_pembayaran'] = $this->model->gen_code('PMB');
            $details['id_user'] = Helpers::getId();
            $details['nis'] = $header['nis'];


            $validator = Validator::make( $header, $this->model->rules['insert']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }
            
            $bulan = $details['bulan'];
            $semester = $details['semester'];
            $nis = $header['nis'];
            $validator_second = Validator::make($details, [
                'bulan' => [
                    'required',
                    Rule::unique('tb_pembayaran_detail')->where(function ($query) use($bulan, $semester, $nis) {
                        return $query->where([
                            'bulan' => $bulan,
                            'semester' => $semester,
                            'nis' => $nis,
                            'batal' => 0
                        ]);
                    }),
                ],
            ]);

            if ($validator_second->fails()) {
                $response = [
                    'message' => $validator_second->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

            //insert data
            DB::beginTransaction();
            try {
                    $this->model->insert_data($header);
                    $this->model_detail->insert_data($details);
                    DB::commit();

                    $response = array(
                        "status" => "success",
                        "message" => 'Item data baru berhasil ditambahkan',
                        "code" => "200",
                    );

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
                
        return view('pembayaran.form', $data);
    }

    public function lookup_form_setoran(Request $request, $id)
    {
        $get_data = DB::table("tb_pembayaran as a")
                    ->join('tb_siswa as b','a.nis','=','b.nis')
                    ->where('a.id_pembayaran', $id)
                    ->select('a.*','b.nama as nama_siswa','b.kelas','b.jurusan')
                    ->first();

        $data = [
            'title'         => 'Setoran Pembayaran',
            'item'          => $get_data,
            'tgl_pembayaran'   => date('Y-m-d'),
            'submit_url'    => $this->nameroutes.'/simpan-setoran',
            'is_edit'       => FALSE,
            'nameroutes'    => $this->nameroutes,  
            'option_bulan'      => (object) $this->bulan,
            'option_semester'   => (object) $this->semester,
        ];

        return view('pembayaran.lookup.setoran', $data);
    }

    public function simpan_setoran(Request $request)
    {
            //jika form sumbit
            if($request->post())
            {
                $details = $request->input('f');
                $details['id_user'] = Helpers::getId();
    
                $bulan = $details['bulan'];
                $semester = $details['semester'];

                $year = date('Y');
                $tanggal = "{$year}-{$bulan}-01";
                $create_bulan_lalu = date('Y-m-d', strtotime('-1 month', strtotime($tanggal)));    
                $bulan_lalu = (date('m', strtotime($create_bulan_lalu)));
                $bulan_lalu_cek = ltrim($bulan_lalu, "0");

                $nis['nis'] = $details['nis'];
 

                $cekPembayaranBulanSebelumnya = DB::table("tb_pembayaran_detail")->where([
                    "nis" => $details['nis'], 
                    // "kelas" => $details['kelas'],  
                    "bulan" => $bulan_lalu_cek,
                    "batal" => 0,
                    "semester" => $details['semester'],  
                ])
                // ->where(DB::raw('YEAR(tgl_pembayaran)'), date('Y', strtotime($create_bulan_lalu)))
                // ->where(DB::raw('MONTH(tgl_pembayaran)'), date('m', strtotime($create_bulan_lalu)))
                ->first();

                // $cekPembayaranBulanSama = DB::table("tb_pembayaran_detail")->where([
                //     "nis" => $details['nis'], 
                //     "kelas" => $details['kelas'],  
                //     "bulan" => $bulan
                // ])->first();


                // if (!empty($cekPembayaranBulanSama)) {
                //     $response = [
                //         'message' => 'Bulan dengan semester dan kelas yang sama sudah dilakukan pembayaran',
                //         'status' => 'error',
                //         'code' => 500,
                //     ];
                //     return Response::json($response);
                // }

                if (empty($cekPembayaranBulanSebelumnya)) {
                    $response = [
                        'message' => 'Bulan lalu belum dilakukan pembayaran',
                        'status' => 'error',
                        'code' => 500,
                    ];
                    return Response::json($response);
                }

                $validator = Validator::make($details, [
                    'bulan' => [
                        'required',
                        Rule::unique('tb_pembayaran_detail')->where(function ($query) use($bulan, $semester, $nis) {
                            return $query->where([
                                'bulan' => $bulan,
                                'semester' => $semester,
                                'nis' => $nis,
                                'batal' => 0
                            ]);
                        }),
                    ],
                ]);
    
                if ($validator->fails()) {
                    $response = [
                        'message' => 'Bulan dengan semester yang sama sudah dilakukan pembayaran',
                        'status' => 'error',
                        'code' => 500,
                    ];
                    return Response::json($response);
                }

                DB::beginTransaction();
                try {
                    $this->model_detail->insert_data($details);
                    DB::commit();
        
                    $response = [
                        "message" => 'Item data baru berhasil dibuat',
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
    }

    public function proses_setoran(Request $request, $id)
    {
        $get_data = $this->model->get_by(['a.id_pembayaran' => $id]);

        $data = [
            'title'         => 'Proses Setoran Pembayaran',
            'item'          => $get_data,
            'nameroutes'    => $this->nameroutes,
            'collection'    => $this->model_detail->get_collection($get_data->id_pembayaran),
            'submit_url'    => url()->current(),   
        ];

        //jika form sumbit
        if($request->post())
        {

            DB::beginTransaction();
            try {
                $this->model_detail->update_data(['proses' => 1], $id);
                DB::commit();

                $response = [
                    "message" => 'Setoran pembayaran berhasil di proses',
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
        
        return view('pembayaran.form.proses_setoran', $data);
    }

    public function simpan_proses_setoran(Request $request, $id)
    {
        $this->model_detail->update_data(['proses' => 1], $id);
        alert()->success('Success', 'Proses setoran pembayaran berhasil!');
        return redirect()->back();
    }

    public function cetak($id)
    {
        $get_data = $this->model_detail->get_one($id);
        $data = [
            'label' => 'Jumlah Setor' ,
            'item'  => $get_data,
            'title' => 'Bukti Pembayaran SPP',
        ];

        // return view('laporan.print.kategori_keuangan', $data);
        $pdf = PDF::loadView('pembayaran.print.cetak_bukti_pembayaran', $data)->setPaper('a5', 'portait');
        return $pdf->stream('Bukti Pembayaran SPP.pdf'); 
    }


    public function edit(Request $request, $id)
    {
        $item = $this->model->get_one($id);

        $data = [
            'title'                 => 'Perbarui Pembayaran',
            'breadcrumb'            => 'Data Pembayaran',
            'item'                  => $item,
            'is_edit'               => TRUE,
            'submit_url'            => url()->current(),
            'nameroutes'            => $this->nameroutes,
            'option_tahun_ajaran' => $this->model_tahun_ajaran->get_all(),
            'option_kategori' => $this->model_kategori->get_all_by(['jenis_kk' => 'Pembayaran']),
            'collection'            => $this->model->collection_detail($item->id),
        ];
        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('header');
            $header['no_transaksi'] = $this->model->gen_code('PMB');
            $details = $request->input('details');

            if ( empty( $details ))
            {
                $response = array(
                    "status" => "error",
                    "message" => 'Terjadi kesalahan! data detail tidak boleh kosong',
                    "code" => "500",
                );
                return Response::json($response);
            }
            //insert data
            DB::beginTransaction();
            try {
                    // update header
                    $this->model->update_data($header, $id);
                    // delete detail
                    $this->model_detail->delete_by(['id_transaksi' => $id]);
                    $data_details = [];
                    foreach($details as $row)
                    {
                        $row['id_transaksi'] = $id;
                        $data_details[] = $row;
                    }

                    // insert detail
                    $this->model_detail->insert_data($data_details);
                    DB::commit();

                    $response = array(
                        "status" => "success",
                        "message" => 'Item data baru berhasil ditambahkan',
                        "code" => "200",
                    );

            } catch (\Exception $e) {
                DB::rollback();
                $response = array(
                    "status" => "error",
                    "message" => 'Terjadi kesalahan! data gagal disimpan',
                    "code" => "500",
                );
            }

            return Response::json($response); 
        }
        
        return view('pembayaran.form', $data);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request, $id)
    {
        $item = $this->model->get_one($id);

        $data = [
            'title'             => 'Perbarui Pembayaran',
            'breadcrumb'        => 'Data Pembayaran',
            'item'              => $item,
            'is_view'           => TRUE,
            'submit_url'        => url()->current(),
            'nameroutes'        => $this->nameroutes,
            'option_tahun_ajaran' => $this->model_tahun_ajaran->get_all(),
            'option_kategori' => $this->model_kategori->get_all(),
            'collection'        => $this->model->collection_detail($item->id),
        ];
        
        return view('pembayaran.form', $data);
    }

    
    public function lookup_detail(Request $request)
    {
        $params_kategori     = $request->get('kategori');
        $params_angkatan     = $request->get('angkatan');
        $get_biaya  = $this->model_biaya->get_by(['id_kk' => $params_kategori,'angkatan' => $params_angkatan]);

        $data = [
            'item'         => $get_biaya,
            'option_bulan' => $this->bulan,
            'option_iuran' => $this->jenis_iuran,
        ];
        return view('pembayaran.lookup.lookup_detail', $data);
    }

    public function batal(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $this->model_detail->update_data(['batal' => 1], $id);
            DB::commit();

            $response = [
                "message" => 'Setoran pembayaran berhasil dibatalkan!',
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

    public function cancel( Request $request, $id )
    {
        $item = $this->model->get_one($id);
        $data = [
            'item'       => $item,
            'submit_url' => url()->current(),
        ];

        //jika form sumbit
        if($request->post())
        {
            if ( $item->status_batal == 1)
            {
                alert()->warning('Tidak dapat dibatalkan karena data sudah dibatalkan!')->persistent('OK');
                return redirect('pengajuan_bos');
            }
            //insert data
            DB::beginTransaction();
            try {
                    // update header
                    $detail_pengajuan = $this->model->get_detail_collection($item->kode_pengajuan);
                    foreach($detail_pengajuan as $row)
                    {
                        $this->model->update_detail_rkam(['sudah_pengajuan' => 0], ['kode_rkam' => $row->kode_rkam, 'noref_pengajuan' => $row->kode_pengajuan]);
                    }
                    $this->model->update_data(['status_batal' => 1], $item->id);
                    DB::commit();

                    alert()->success('Data berhasil dibatalkan!', 'Sukses!'); 

            } catch (\Exception $e) {
                DB::rollback();
                alert()->warning('Data gagal dibatalkan!', 'Perhatian!')->persistent('OK');
            }

            return redirect('pengajuan_bos'); 
        }
        return view('pengajuan_bos.modal.delete', $data);
    }


}
