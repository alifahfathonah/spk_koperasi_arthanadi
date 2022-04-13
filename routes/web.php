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

// Route::group(['middleware' => ['admin']], function () {
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
});
#PENARIKAN
Route::prefix('penarikan')->group(function() {
    Route::get('/', 'PenarikanController@index');
	Route::match(array('GET', 'POST'),'/datatables','PenarikanController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PenarikanController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PenarikanController@edit');
	Route::match(array('GET', 'POST'),'/view/{id}','PenarikanController@view');
});

#AKUN
Route::prefix('akun')->group(function() {
    Route::get('/', 'AkunController@index');
	Route::match(array('GET', 'POST'),'/datatables','AkunController@datatables_collection');
	Route::match(array('GET', 'POST'),'/datatables-lookup-collection','AkunController@datatables_lookup_collection');
	Route::match(array('GET', 'POST'),'/datatables-rkas-collection','AkunController@datatables_rkas_collection');
	Route::match(array('GET', 'POST'),'/create','AkunController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','AkunController@edit');
});

#PEMBAYARAN SPP
Route::prefix('pembayaran-spp')->group(function() {
    Route::get('/', 'PembayaranController@index');
	Route::match(array('GET', 'POST'),'/datatables','PembayaranController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PembayaranController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PembayaranController@edit');
	Route::match(array('GET'),'/setoran/{id}','PembayaranController@lookup_form_setoran');
	Route::match(array('POST'),'/simpan-setoran','PembayaranController@simpan_setoran');
	Route::match(array('GET', 'POST'),'/proses-setoran/{id}','PembayaranController@proses_setoran');
	Route::match(array('GET', 'POST'),'/simpan-proses-setoran/{id}','PembayaranController@simpan_proses_setoran');
	Route::match(array('GET'),'/cetak/{id}','PembayaranController@cetak');
	Route::match(array('GET', 'POST'),'/batal/{id}','PembayaranController@batal');
});

#RKAS
Route::prefix('rkas')->group(function() {
    Route::get('/', 'RkasController@index');
	Route::match(array('GET', 'POST'),'/datatables','RkasController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','RkasController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','RkasController@edit');
	Route::match(array('GET'),'/cetak/{id}','RkasController@cetak');
});
#PENGELUARAN
Route::prefix('pengeluaran')->group(function() {
    Route::get('/', 'PengeluaranController@index');
	Route::match(array('GET', 'POST'),'/datatables','PengeluaranController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','PengeluaranController@create');
	Route::match(array('GET', 'POST'),'/edit/{id}','PengeluaranController@edit');
	Route::match(array('GET', 'POST'),'/cancel/{id}','PengeluaranController@cancel');
	Route::match(array('GET'),'/cetak/{id}','PengeluaranController@cetak');
	Route::match(array('GET', 'POST'),'/lookup_detail','PengeluaranController@lookup_detail');
	Route::match(array('GET', 'POST'),'/detail/{id}','PengeluaranController@detail');
	Route::post('/upload-nota','PengeluaranController@image_upload');
	Route::match(array('GET', 'POST'),'/riwayat/{id}','PengeluaranController@riwayat');
});

#JURNAL
Route::prefix('jurnal')->group(function() {
    Route::get('/', 'JurnalController@index');
	Route::match(array('GET', 'POST'),'/datatables','JurnalController@datatables_collection');
	Route::match(array('GET', 'POST'),'/create','JurnalController@create');
	Route::match(array('GET', 'POST'),'/detail/{id}','JurnalController@detail');
	Route::match(array('GET', 'POST'),'/lookup_akun','JurnalController@lookup_akun');
});

#TRANSAKSI
Route::prefix('transaksi')->group(function() {
    Route::get('/', 'TransaksiController@index');
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

// });











// =========================================================================================================================

?>