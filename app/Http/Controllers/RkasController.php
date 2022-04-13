<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Rkas_m;
use Validator;
use DataTables;
use Helpers;
use DB;
use Response;

class RkasController extends Controller
{
    public function __construct()
    {
        $this->model = New Rkas_m;
        $this->nameroutes = 'rkas';
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
                'title'             => 'Data RKAS',
                'breadcrumb'        => 'List Data RKAS',
                'headerModalTambah' => 'TAMBAH DATA RKAS',
                'headerModalEdit'   => 'UBAH DATA RKAS',
                'urlDatatables'     => $this->nameroutes.'/datatables',
                'idDatatables'      => 'dt_rkas'
            );
            return view('rkas.datatable',$data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function create(Request $request)
    {
        $item = [
            'id_rkas' => null,
            'nominal' => null,
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

            //validasi dari model
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
                    "message" => 'Item data baru berhasil dibuat',
                    'status' => 'success',
                    'code' => 200,
                ];
    
            } catch (Throwable $e) {
                DB::rollback();
                $response = [
                    "message" => 'Item data baru gagal dibuat',
                    'status' => 'error',
                    'code' => 500,
                    
                ];
            }
    
            return Response::json($response);
        }

        return view('rkas.form', $data);

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
            'nameroutes'            => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');

           //validasi dari model
           $validator = Validator::make( $header, $this->model->rules['update']);
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
                    "message" => 'Item data berhasil diperbarui',
                    'status' => 'success',
                    'code' => 200,
                ];
            } catch (Throwable $e) {
                DB::rollback();
                $response = [
                    "message" => 'Item data gagal diperbarui',
                    'status' => 'error',
                    'code' => 500,
                ];
            }
            return Response::json($response); 
        }
        
        return view('rkas.form', $data);
    }


}
