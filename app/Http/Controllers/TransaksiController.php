<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DataTables;
use Helpers;
use DB;
use Response;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->nameroutes = 'transaksi';
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
                'title'             => 'Transaksi',
                'breadcrumb'        => 'Transaksi',
            );

            return view('transaksi.menu_transaksi',$data);
    }


}
