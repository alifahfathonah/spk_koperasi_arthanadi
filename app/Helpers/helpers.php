<?php
namespace App\Helpers;

use App\Http\Model\Bobot_kriteria_m;
use Session;
use App\Http\Model\Jabatan_m;
use App\Http\Model\Config_m;

class Helpers{

    public static function isLogin()
    {
        return (Session::get('login'));
    }

    public static function getId()
    {
        return (Session::get('id'));

    }

    public static function getNama()
    {
        return (Session::get('nama'));
    }

    public static function getJabatan()
    {
        // $model_jabatan = New Jabatan_m;
        // $query = $model_jabatan->get_one(Session::get('jabatan'));
        // return $query->jabatan;
        return (Session::get('jabatan'));
    }

    public static function isBendahara()
    {
        $model_jabatan = New Jabatan_m;
        $query = $model_jabatan->get_one(Session::get('jabatan'));
        return ($query->jabatan == 'Bendahara');
    }

    public static function isKepalaSekolah()
    {
        $model_jabatan = New Jabatan_m;
        $query = $model_jabatan->get_one(Session::get('jabatan'));
        return ($query->jabatan == 'Kepala Sekolah');
    }
    public static function isKetuaYayasan()
    {
        $model_jabatan = New Jabatan_m;
        $query = $model_jabatan->get_one(Session::get('jabatan'));
        return ($query->jabatan == 'Ketua Yayasan');

    }

    public static function config_item( $params )
    {
        $model_config = New Config_m;
        $query = $model_config->get_one($params);
        return $query->value;
    }

}