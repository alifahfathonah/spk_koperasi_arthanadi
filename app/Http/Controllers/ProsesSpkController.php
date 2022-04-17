<?php

namespace App\Http\Controllers;

use App\Http\Model\Alternatif_m;
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
    public function __construct(Proses_spk_m $model, Pengajuan_m $model_pengajuan)
    {
        $this->model = $model;
        $this->model_pengajuan = $model_pengajuan;
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

    public function create(Request $request)
    {
        $item = [
            'kode_alternatif'  => null,
            'id_pengajuan' => null,
        ];
        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes
        );
        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            
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

        return view('alternatif.form', $data);

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

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

}
