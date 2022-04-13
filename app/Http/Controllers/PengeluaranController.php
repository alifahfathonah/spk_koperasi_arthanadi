<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Pengeluaran_m;
use App\Http\Model\Pengeluaran_detail_m;
use App\Http\Model\Akun_m;
use Validator;
use DataTables;
use Helpers;
use DB;
use Response;

class PengeluaranController extends Controller
{
    public function __construct()
    {
        $this->model = New Pengeluaran_m;
        $this->model_detail = New Pengeluaran_detail_m;
        $this->model_akun = New Akun_m;
        $this->nameroutes = 'pengeluaran';
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
                'title'             => 'Data Pengeluaran',
                'breadcrumb'        => 'List Data Pengeluaran',
                'urlDatatables'     => "{$this->nameroutes}/datatables",
                'idDatatables'      => 'dt_pengeluaran'
            );
            return view('pengeluaran.datatable',$data);
    }

    public function create(Request $request)
    {
        $item = [
            'id_pengeluaran' =>  $this->model->gen_code('TRP'),
            'total' => 0,
            'tanggal' => date('Y-m-d'),
            'bukti_struk' => null
        ];

        $data = array(
            'item'              => (object) $item,
            'title'             => 'Buat Pengeluaran',
            'breadcrumb'        => 'Daftar Pengeluaran',
            'submit_url'        => url()->current(),
            'is_edit'           => FALSE,
            'nameroutes'        => $this->nameroutes,
        );

        //jika form sumbit
        if($request->post())
        {
            //request dari view
            $header = array_merge($item, $request->input('header'));
            $header['id_pengeluaran'] = $this->model->gen_code('TRP');
            $header['id_user'] = Helpers::getId();

            $details = $request->input('details');

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
                //insert header get id
                $this->model->insert_data($header);
                $data_details = [];
                foreach($details as $row)
                {
                    $row['id_pengeluaran'] = $header['id_pengeluaran'];
                    $data_details[] = $row;
                }
                // insert detail
                $this->model_detail->insert_data($data_details);
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

        return view('pengeluaran.form', $data);

    }

    public function lookup_detail( $id = null)
    {
        return view('pengeluaran.lookup.lookup_detail');
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
    public function detail(Request $request, $id)
    {
        $get_data = $this->model->get_one($id);
        $data = [
            'item'                      => $get_data,
            'title'                     => 'Lihat Pengeluaran',
            'breadcrumb'                => 'Daftar Pengeluaran',
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'                => $this->nameroutes,
            'collection'                => $this->model_detail->collection($get_data->id_pengeluaran)
        ];

        //jika form sumbit
        if($request->post())
        {
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data(['status_batal' => 1], $id);
                DB::commit();

                $response = [
                    "message" => 'Item data berhasil dibatalkan!',
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
        
        return view('pengeluaran.form', $data);
    }

    public function cancel(Request $request, $id)
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
            if($get_data->status_batal == 1){
                alert()->warning('Perhatian', 'Item data ini sudah dibatalkan!');
                return redirect('/pengeluaran');  
            }
            //insert data
            DB::beginTransaction();
            try {
                $this->model->update_data(['status_batal' => 1, 'id_user' => Helpers::getId(), 'tanggal_dibatalkan' => date('Y-m-d')], $id);
                DB::commit();

                alert()->success('Success', 'Item data berhasil dibatalkan');
            } catch (Throwable $e) {
                DB::rollback();
                alert()->success('Success', 'Item data gagal dibatalkan');
        }
        
        return redirect('/pengeluaran');  
    }
        
        return view('pengeluaran.modal.delete', $data);
    }
    
    public function image_upload(Request $request)
    {

        $file       = $request->file('bukti_struk');
        $fileName   = $file->getClientOriginalName();
        $newName    = $fileName;
        $file->move('themes/default/images/bukti_struk',$newName);

        if (!empty($newName))
        {
            $response = array(
                "filename" => $newName,
                "status" => "success",
                "message" => 'Upload image sukses',
                "code" => "200",
            );
            
        }
        else{
            $response = array(
                "status" => "error",
                "message" => 'Terjadi kesalahan! upload image gagal',
                "code" => "500",
            );
        }
        return Response::json($response);
    }

    public function datatables_collection()
    {
        $data = $this->model->get_all();
        return Datatables::of($data)->make(true);
    }

    public function datatables_collection_no_tabungan()
    {
        $data = $this->model->get_all_no_tabungan();
        return Datatables::of($data)->make(true);
    }

    public function riwayat(Request $request, $id)
    {
        // $get_data = $this->model->get_one($id);
        $query = DB::table('tb_pengeluaran as a')
                    ->join('tb_user as b','a.id_user','=','b.id')
                    ->select('a.*','b.nama_user')
                    ->where("a.id", $id)
                    ->first();

        $data = [
            'item'                      => $query,
            'is_edit'                   => TRUE,
            'submit_url'                => url()->current(),
            'nameroutes'            => $this->nameroutes,
        ];
        
        return view('pengeluaran.modal.riwayat', $data);
    }


}
