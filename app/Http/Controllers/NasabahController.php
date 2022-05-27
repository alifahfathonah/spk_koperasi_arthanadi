<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Nasabah_m;
use Validator;
use DataTables;
use Illuminate\Validation\Rule;
use DB;
use Response;

class NasabahController extends Controller
{
    protected $jenis_kelamin = [
        ['id' => 'L', 'desc' => 'Laki-Laki'],
        ['id' => 'P', 'desc' => 'Perempuan'],
    ];

    protected $agama = [
        ['id' => 'Hindu', 'desc' => 'Hindu'],
        ['id' => 'Muslim', 'desc' => 'Muslim'],
        ['id' => 'Kristen', 'desc' => 'Kristen'],
        ['id' => 'Katolik', 'desc' => 'Katolik'],
        ['id' => 'Buddha', 'desc' => 'Buddha'],
        ['id' => 'Konghucu', 'desc' => 'Konghucu'],
    ];

    public function __construct()
    {
        $this->model = New Nasabah_m;
        $this->nameroutes = 'nasabah';
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
                'title'             => 'Data Nasabah',
                'breadcrumb'        => 'List Data Nasabah',
                'headerModalTambah' => 'TAMBAH DATA NASABAH',
                'headerModalEdit'   => 'UBAH DATA NASABAH',
                'headerModalDetail' => 'DETAIL DATA NASABAH',
                'urlDatatables'     => 'nasabah/datatables',
                'idDatatables'      => 'dt_nasabah'
            );
            return view('nasabah.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_nasabah' => $this->model->gen_code('NB'),
            'nama_nasabah' => null,
        ];

        $data = array(
            'item'                  => (object) $item,
            'submit_url'            => url()->current(),
            'is_edit'               => FALSE,
            'option_jenis_kelamin'  => $this->jenis_kelamin,
            'option_agama'  => $this->agama,
            'nameroutes'            => $this->nameroutes,
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
                    "message" => 'Data nasabah berhasil dibuat',
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

        return view('nasabah.form', $data);

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
            'option_jenis_kelamin'              => $this->jenis_kelamin,
            'option_agama'  => $this->agama,
            'nameroutes'                => $this->nameroutes,
        ];

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = $request->input('f');

           //validasi dari model
           $validator = Validator::make( $header, [
                'id_nasabah' => [Rule::unique('tb_nasabah')->ignore($get_data->id_nasabah, 'id_nasabah')],
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
                    "message" => 'Data nasabah berhasil diperbarui',
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
        
        return view('nasabah.form', $data);
    }

    public function view($id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'is_edit'                   => TRUE,
            'nameroutes'                => $this->nameroutes,
        ];

        return view('nasabah.view', $data);
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $this->model->update_data(['aktif' => 0], $id);
            DB::commit();

            $response = [
                "message" => 'Data nasabah berhasil dihapus',
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
