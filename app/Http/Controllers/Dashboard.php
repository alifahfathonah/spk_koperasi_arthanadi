<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DataTables;
use Response;
use DB;
use Helpers;

class Dashboard extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::table('tb_hasil as a')
                ->join('tb_alternatif as b','a.alternatif','=','b.kode_alternatif')
                ->join('tb_nasabah as c','b.id_nasabah','=','c.id')
                ->where([
                    'b.aktif' => 1,
                    'c.aktif' => 1
                ])
                ->select('a.*','c.nama_nasabah')
                ->get();

        foreach($query as $data)
        {
            $array[] = [
                $data->nama_nasabah, 
                $data->hasil
            ];
        }
        $data = [
            'title' => 'Dashboard',
            'data_chart' => @$array
        ];
        return view('dashboard.dashboard', $data);

    }

    public function chart(Request $request)
    {

    }

    
}
