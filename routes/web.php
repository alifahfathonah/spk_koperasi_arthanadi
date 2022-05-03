<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 

// RUOTE DIPAKAI =============================================================================================================
Route::get('/',function(){
	return view('auth.login');
});

Route::get('/login','Login@login');
Route::post('/auth','Login@auth');
Route::get('/logout', 'Login@logout');

Route::group(['middleware' => ['admin']], function () {
#PETUGAS
Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
	Route::match(array('GET', 'POST'),'/datatables','UserController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','UserController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','UserController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','UserController@view');
});
#NASABAH
Route::prefix('nasabah')->group(function() {
    Route::get('/', 'NasabahController@index');
	Route::match(array('GET', 'POST'),'/datatables','NasabahController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','NasabahController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','NasabahController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','NasabahController@view');
});
#KRITERIA
Route::prefix('kriteria')->group(function() {
    Route::get('/', 'KriteriaController@index');
	Route::match(array('GET', 'POST'),'/datatables','KriteriaController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','KriteriaController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','KriteriaController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','KriteriaController@view');
});
#GROUP KRITERIA
Route::prefix('group-kriteria')->group(function() {
    Route::get('/', 'GroupKriteriaController@index');
	Route::match(array('GET', 'POST'),'/datatables','GroupKriteriaController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','GroupKriteriaController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','GroupKriteriaController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','GroupKriteriaController@view');
});
#PENGAJUAN
Route::prefix('pengajuan')->group(function() {
    Route::get('/', 'PengajuanController@index');
	Route::match(array('GET', 'POST'),'/datatables','PengajuanController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PengajuanController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PengajuanController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','PengajuanController@view');
	Route::match(array('GET', 'POST'),'/lookup_alternatif','PengajuanController@datatables_lookup_alternatif');
});
#ALTERNATIF
Route::prefix('alternatif')->group(function() {
    Route::get('/', 'AlternatifController@index');
	Route::match(array('GET', 'POST'),'/datatables','AlternatifController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','AlternatifController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','AlternatifController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','AlternatifController@view');
});
#ALTERNATIF
Route::prefix('proses-spk')->group(function() {
    Route::get('/', 'ProsesSpkController@index');
	Route::match(array('GET', 'POST'),'/datatables','ProsesSpkController@datatables_collection');
	Route::match(array('GET', 'POST'),'/proses-normalisasi','ProsesSpkController@proses_normalisasi');
	Route::match(array('GET', 'POST'),'/proses-fucom-smart','ProsesSpkController@proses_fucom_smart');
	Route::match(array('GET', 'POST'),'/normalisasi','ProsesSpkController@normalisasi');
	Route::match(array('GET', 'POST'),'/fucom-smart','ProsesSpkController@fucom_smart');
	Route::match(array('GET', 'POST'),'/datatables-normalisasi','ProsesSpkController@datatables_collection_normalisasi');
	Route::match(array('GET', 'POST'),'/datatables-fucom-smart','ProsesSpkController@datatables_collection_fucom_smart');
});
#DASHBOARD
Route::prefix('dashboard')->group(function() {
	Route::get('/','Dashboard@index');
	Route::get('/dashboard-master','Dashboard@dashboard_master');
	Route::get('/dashboard-laporan','Dashboard@dashboard_laporan');
	Route::post('/chart','Dashboard@chart');
	Route::match(array('GET', 'POST'),'/info_siswa','Dashboard@info_siswa');
	Route::match(array('GET', 'POST'),'/info_pemasukan','Dashboard@info_pemasukan');
	Route::match(array('GET', 'POST'),'/info_pengeluaran','Dashboard@info_pengeluaran');
});
#LAPORAN
Route::prefix('laporan')->group(function() {
	Route::get('/pembayaran','Laporan@pembayaran');
	Route::post('/pembayaran/print','Laporan@print_pembayaran');

	Route::get('/rekapitulasi','Laporan@rekapitulasi');
	Route::post('/rekapitulasi/print','Laporan@print_rekapitulasi');

	Route::get('/tunggakan','Laporan@tunggakan');
	Route::post('/tunggakan/print','Laporan@print_tunggakan');
	
	Route::get('/rkas','Laporan@rkas');
	Route::post('/rkas/print','Laporan@print_rkas');

	Route::get('/pengeluaran','Laporan@pengeluaran');
	Route::post('/pengeluaran/print','Laporan@print_pengeluaran');

	Route::get('/lpj','Laporan@lpj');
	Route::post('/lpj/print','Laporan@print_lpj');

	Route::get('/arus-kas','Laporan@arus_kas');
	Route::post('/arus-kas/print','Laporan@print_arus_kas');

	Route::get('/perubahan-modal','Laporan@perubahan_modal');
	Route::post('/perubahan-modal/print','Laporan@print_perubahan_modal');

	Route::get('/neraca','Laporan@neraca');
	Route::post('/neraca/print','Laporan@print_neraca');
});

});











// =========================================================================================================================

?>