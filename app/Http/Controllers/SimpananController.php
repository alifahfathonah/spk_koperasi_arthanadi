<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Simpanan_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class SimpananController extends Controller
{
    protected $model;
    public function __construct(Simpanan_m $model)
    {
        $this->model = $model;
        $this->nameroutes = 'simpanan';
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
                'title'             => 'Data Simpanan',
                'breadcrumb'        => 'List Data Simpanan',
                'headerModalTambah' => 'TAMBAH DATA SIMPANAN',
                'headerModalEdit'   => 'UBAH DATA SIMPANAN',
                'headerModalDetail' => 'DETAIL DATA SIMPANAN',
                'urlDatatables'     => 'simpanan/datatables',
                'idDatatables'      => 'dt_simpanan'
            );
            return view('simpanan.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_simpanan' => $this->model->gen_code('SMP'),
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
            $header['id_simpanan'] = $this->model->gen_code('SMP');

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
                    "message" => 'Data simpanan berhasil disimpan',
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

        return view('simpanan.form', $data);

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
                'id_simpanan' => [Rule::unique('tb_simpanan')->ignore($get_data->id_simpanan, 'id_simpanan')],
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
                    "message" => 'Data simpanan berhasil diperbarui',
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
        
        return view('simpanan.form', $data);
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

        return view('simpanan.view', $data);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function get_saldo($id_anggota)
    {
        $simpanan  = $this->model->get_simpanan($id_anggota);
        $penarikan = $this->model->get_penarikan($id_anggota);
        $saldo_akhir  = $simpanan - $penarikan;

        return $saldo_akhir;
    }

}
