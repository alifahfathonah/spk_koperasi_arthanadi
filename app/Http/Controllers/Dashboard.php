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
        $query = DB::table('tb_hasil')->get();
        foreach($query as $data)
        {
            $array[] = [
                $data->alternatif, 
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
