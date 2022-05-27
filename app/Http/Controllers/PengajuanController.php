<?php

namespace App\Http\Controllers;

use App\Http\Model\Kriteria_m;
use Illuminate\Http\Request;
use App\Http\Model\Pengajuan_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class PengajuanController extends Controller
{
    protected $model;
    protected $model_kriteria;
    public function __construct(Pengajuan_m $model, Kriteria_m $model_kriteria)
    {
        $this->model = $model;
        $this->model_kriteria = $model_kriteria;
        $this->nameroutes = 'pengajuan';
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
            'title'             => 'Data Alternatif',
            'breadcrumb'        => 'List Data Alternatif',
            'headerModalTambah' => 'TAMBAH DATA ALTERNATIF',
            'headerModalEdit'   => 'UBAH DATA ALTERNATIF',
            'headerModalDetail' => 'DETAIL DATA ALTERNATIF',
            'urlDatatables'     => 'pengajuan/datatables',
            'idDatatables'      => 'dt_pengajuan'
        );
        return view('pengajuan.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_pengajuan'  => $this->model->gen_code('PGJ'),
            'tgl_pengajuan' => date('Y-m-d'),
        ];
        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
            'jaminan'               => $this->model_kriteria::where('kode_kriteria', 'C1')->get(),
            'karakter'               => $this->model_kriteria::where('kode_kriteria', 'C2')->get(),
            'pendapatan'               => $this->model_kriteria::where('kode_kriteria', 'C3')->get(),
            'pengeluaran'               => $this->model_kriteria::where('kode_kriteria', 'C4')->get(),
            'kemampuan'               => $this->model_kriteria::where('kode_kriteria', 'C5')->get(),
            'kondisi_hutang'               => $this->model_kriteria::where('kode_kriteria', 'C6')->get()
        );
        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['id_pengajuan'] = $this->model->gen_code('PGJ');
            
            $validator = Validator::make( $header, $this->model->rules['insert']);
            if ($validator->fails()) {
                $response = [
                    'message' => $validator->errors()->first(),
                    'status' => 'error',
                    'code' => 500,
                ];
                return Response::json($response);
            }

            DB::beginTransaction();
            try {
                $this->model->insert_data($header);
                DB::commit();
    
                $response = [
                    "message" => 'Data alternatif berhasil disimpan',
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

        return view('pengajuan.form', $data);

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
            'jaminan'               => $this->model_kriteria::where('kode_kriteria', 'C1')->get(),
            'karakter'               => $this->model_kriteria::where('kode_kriteria', 'C2')->get(),
            'pendapatan'               => $this->model_kriteria::where('kode_kriteria', 'C3')->get(),
            'pengeluaran'               => $this->model_kriteria::where('kode_kriteria', 'C4')->get(),
            'kemampuan'               => $this->model_kriteria::where('kode_kriteria', 'C5')->get(),
            'kondisi_hutang'               => $this->model_kriteria::where('kode_kriteria', 'C6')->get()
        ];

        //jika form sumbit
        if($request->post())
        {
           //request dari view
           $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header, [
                'id_pengajuan' => [Rule::unique('tb_pengajuan')->ignore($get_data->id_pengajuan, 'id_pengajuan')],
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
        
        return view('pengajuan.form', $data);
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

        return view('pengajuan.view', $data);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model->update_data(['aktif' => 0], $id);
            DB::commit();

            $response = [
                "message" => 'Data alternatif berhasil dihapus',
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

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function datatables_lookup_alternatif()
    {
        $data = $this->model->get_all_lookup_alternatif();
        return Datatables::of($data)->make(true);
    }


}
