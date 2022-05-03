<?php

use App\Http\Model\Bobot_kriteria_m;

if (!function_exists('format_date_ind')){
    function format_date_ind($date)
    {
        setlocale(LC_TIME, 'id');
        return \Carbon\Carbon::parse($date)->formatLocalized("%A, %d %B %Y");
    }    
}
if (!function_exists('format_datetime_ind')){
    function format_datetime_ind($date)
    {
        setlocale(LC_TIME, 'id');
        return \Carbon\Carbon::parse($date)->formatLocalized("%A, %d %B %Y %H:%M %p");
    }    
}
if (!function_exists('format_date')){
    function format_date($date)
    {
        return \Carbon\Carbon::parse($date)->format("d-m-Y");
    }
}

if (!function_exists('get_user')){
    function get_user()
    {
        return (Session::get('user'));
    }
}
if (!function_exists('bobot_kriteria')){
    function bobot_kriteria( $params )
    {
        $model_config = New Bobot_kriteria_m;
        $query = $model_config->get_one($params);
        return $query->value;
    }
}