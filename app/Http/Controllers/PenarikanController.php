<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Penarikan_m;
use App\Http\Model\Simpanan_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class PenarikanController extends Controller
{
    protected $model;
    protected $model_simpanan;
    public function __construct(Penarikan_m $model, Simpanan_m $model_simpanan)
    {
        $this->model = $model;
        $this->model_simpanan = $model_simpanan;
        $this->nameroutes = 'penarikan';
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
            'title'             => 'Data Penarikan',
            'breadcrumb'        => 'List Data Penarikan',
            'headerModalTambah' => 'TAMBAH DATA PENARIKAN',
            'headerModalEdit'   => 'UBAH DATA PENARIKAN',
            'headerModalDetail' => 'DETAIL DATA PENARIKAN',
            'urlDatatables'     => 'penarikan/datatables',
            'idDatatables'      => 'dt_penarikan'
        );
        return view('penarikan.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_penarikan' => $this->model->gen_code('PNR'),
            'tanggal' => date('Y-m-d'),
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            $header = $request->input('f');
            $header['id_penarikan'] = $this->model->gen_code('PNR');

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
                    "message" => 'Data penarikan berhasil disimpan',
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

        return view('penarikan.form', $data);

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
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');

           //validasi dari model
           $validator = Validator::make( $header, [
                'id_penarikan' => [Rule::unique('tb_penarikan')->ignore($get_data->id_penarikan, 'id_penarikan')],
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
                    "message" => 'Data penarikan berhasil diperbarui',
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
        
        return view('penarikan.form', $data);
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

        return view('penarikan.view', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

}
