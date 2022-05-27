<?php

namespace App\Http\Controllers;

use App\Http\Model\Group_kriteria_m;
use App\Http\Model\GroupKriteria_m;
use Illuminate\Http\Request;
use App\Http\Model\Kriteria_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use Helpers;
use DB;
use Response;

class KriteriaController extends Controller
{
    public function __construct()
    {
        $this->model = New Kriteria_m;
        $this->nameroutes = 'kriteria';
        
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
                'title'             => 'Data Bobot Kriteria',
                'breadcrumb'        => 'List Data Bobot Kriteria',
                'headerModalTambah' => 'TAMBAH DATA BOBOT KRITERIA',
                'headerModalEdit'   => 'UBAH DATA BOBOT KRITERIA',
                'urlDatatables'     => 'kriteria/datatables',
                'idDatatables'      => 'dt_kriteria'
            );
            return view('kriteria.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'nama_kriteria' => null,
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'nameroutes'            => $this->nameroutes,
            'kriteria'              => Group_kriteria_m::get()
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
                    "message" => 'Data bobot kriteria berhasil dibuat',
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

        return view('kriteria.form', $data);

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
            'item'           => $get_data,
            'is_edit'        => TRUE,
            'submit_url'     => url()->current(),
            'nameroutes'     => $this->nameroutes,
            'kriteria'       => Group_kriteria_m::get()
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');
           //validasi dari model
           $validator = Validator::make( $header,[
                'kode_kriteria' => ['required'],
                'nama_kriteria' => ['required'],
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
                    "message" => 'Data bobot kriteria berhasil diperbarui',
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
        
        return view('kriteria.form', $data);
    }
    
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model->update_data(['aktif' => 0], $id);
            DB::commit();

            $response = [
                "message" => 'Data bobot kriteria berhasil dihapus',
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
