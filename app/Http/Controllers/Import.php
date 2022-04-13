<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Model\Siswa_m;
use App\Http\Model\Petugas_m;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Redirect;

class Import extends Controller
{
    public function __construct()
    {
        $this->model_siswa = New Siswa_m;
        $this->model_user = New Petugas_m;
    }

    public function import_siswa(Request $request) 
    {
        $data = Excel::load($request->file('file'), function($reader) {})->get();
        if(!empty($data) && $data->count())
        {

            foreach($data->toArray() as $row)
            {
                DB::beginTransaction();
                try {
                    //cek nis di tabel
                    $cekNis = $this->model_siswa->get_by(['nis' => $row['nis']]);
                    if(!empty($cekNis))
                    {
                        $this->model_siswa->update_by(['nis' => $row['nis']], 
                            [
                                'nis' => $row['nis'],
                                'nama' => $row['nama'],
                                'tempat_lahir' => $row['tempat_lahir'],
                                'tanggal_lahir' => $row['tanggal_lahir'],
                                'jenis_kelamin' => $row['jk'],
                                'alamat' => $row['alamat'],
                                'no_telp' => $row['no_telp'],
                                'agama' => $row['agama'],
                                'kelas' => $row['kelas'],
                                'jurusan' => $row['jurusan'],
                            ]);
                        $this->model_user->update_by(['id' => $cekNis->id_user], 
                            [
                                'id_user' => $this->model_user->gen_code('U'),
                                'nama_user' => $row['nama'],
                                'username' => $row['nis'],
                                'password' => bcrypt($row['nis']),
                                'jabatan' => 'Siswa',
                                'no_telp' => $row['no_telp'],
                                'jenis_kelamin' => $row['jk'],
                                'alamat' => $row['alamat'],
                                'aktif' => 1
                            ]);
                    }else{
                        $tbl_user = [
                            'id_user' => $this->model_user->gen_code('U'),
                            'nama_user' => $row['nama'],
                            'username' => $row['nis'],
                            'password' => bcrypt($row['nis']),
                            'jabatan' => 'Siswa',
                            'no_telp' => $row['no_telp'],
                            'jenis_kelamin' => $row['jk'],
                            'alamat' => $row['alamat'],
                            'aktif' => 1
                        ];

                        $id_user = Petugas_m::insertGetId($tbl_user);
    
                        $tbl_siswa = [
                            'nis' => $row['nis'],
                            'nama' => $row['nama'],
                            'tempat_lahir' => $row['tempat_lahir'],
                            'tanggal_lahir' => $row['tanggal_lahir'],
                            'jenis_kelamin' => $row['jk'],
                            'alamat' => $row['alamat'],
                            'no_telp' => $row['no_telp'],
                            'agama' => $row['agama'],
                            'kelas' => $row['kelas'],
                            'jurusan' => $row['jurusan'],
                            'id_user' => $id_user,
                        ];

                        $this->model_siswa->insert_data($tbl_siswa);
                    }
                    DB::commit();              
                    alert()->success('Data berhasil diimport!', 'Sukses!')->persistent('OK');

                } catch (\Throwable $e) {
                    DB::rollback();
                    throw $e;
                    alert()->warning('Data gagal diimport!', 'Perhatian!')->persistent('OK');
                }
            }

        }
        return Redirect::back(); 
    }


}
