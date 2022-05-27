<?php

namespace App\Http\Controllers;

use App\Http\Model\Alternatif_m;
use App\Http\Model\Pengajuan_m;
use App\Http\Requests\AlternatifRequest;
use Illuminate\Http\Request;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class AlternatifController extends Controller
{
    protected $model;
    protected $model_pengajuan;
    protected $alternatif_request;
    public function __construct(Alternatif_m $model, Pengajuan_m $model_pengajuan, AlternatifRequest $alternatif_request)
    {
        $this->model = $model;
        $this->model_pengajuan = $model_pengajuan;
        $this->alternatif_request = $alternatif_request;
        $this->nameroutes = 'alternatif';
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
            'title'             => 'Data Pengajuan',
            'breadcrumb'        => 'List Data Pengajuan',
            'headerModalTambah' => 'TAMBAH DATA PENGAJUAN',
            'headerModalEdit'   => 'UBAH DATA PENGAJUAN',
            'headerModalDetail' => 'DETAIL DATA PENGAJUAN',
            'urlDatatables'     => 'alternatif/datatables',
            'idDatatables'      => 'dt_alternatif'
        );
        return view('alternatif.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'kode_alternatif'  => $this->model->gen_code('A'),
            'id_nasabah' => null,
        ];
        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
            'pengajuan'               => $this->model_pengajuan::get(),
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
                    "message" => 'Data pengajuan berhasil disimpan',
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
            'pengajuan'                  => $this->model_pengajuan::get(),
        ];

        //jika form sumbit
        if($request->post())
        {
           //request dari view
           $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header, [
                'id_nasabah' => [Rule::unique('tb_alternatif')->ignore($get_data->id_nasabah, 'id_nasabah')],
                'kode_alternatif' => [Rule::unique('tb_alternatif')->ignore($get_data->kode_alternatif, 'kode_alternatif')],
            ], [], $this->alternatif_request->attributes());
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
                    "message" => 'Data pengajuan berhasil diperbarui',
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

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model->update_data(['aktif' => 0], $id);
            DB::commit();

            $response = [
                "message" => 'Data pengajuan berhasil dihapus',
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

}
