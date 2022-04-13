<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembayaran_m extends Model
{
	protected $table = 'tb_pembayaran';
	protected $index_key = 'id';
	protected $index_key2 = 'id_pembayaran';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_pembayaran' => "required|unique:{$this->table}",
				'nis' => "required|unique:{$this->table}",
				// 'tgl_pembayaran' => 'required',
            ],
			'update' => [
				'id_pembayaran' => 'required',
				'nis' => 'required',
				// 'tgl_pembayaran' => 'required',
            ],
        ];

	}

    function get_all()
    {
		$query = DB::table('tb_pembayaran as a')
				->join('tb_siswa as b','a.nis','=','b.nis')
				->select('a.*','b.nama as nama_siswa','tanggal_lahir','jenis_kelamin','alamat','no_telp','jurusan','agama','kelas');
        return $query->get();
    }

	function get_pembayaran_spp($params,  $id_kk = 13)
    {
		if($params['status_bayar'] == "Sudah Bayar"){
			$query = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['id_kelas']) && $params['id_kelas'] != ""){
				$query->where('b.id_kelas', $params['id_kelas']);
			}
			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$query->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$query->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}
		}else{
			$pembayaran = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['id_kelas']) && $params['id_kelas'] != ""){
				$pembayaran->where('b.id_kelas', $params['id_kelas']);
			}
			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$pembayaran->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$pembayaran->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}

			foreach($pembayaran->get() as $sis)
			{
				$nis[] = $sis->nis;
			}

			$query = DB::table('tb_siswa as a')
					->join('tb_kelas as b','a.id_kelas','=','b.id')
					->select('a.*','b.tingkat_kelas');
			if(!empty($nis)){
				$query->whereNotIn('a.nis', $nis);
			}

		}


        return $query->get();
    }

	function get_pembayaran_gedung($params, $id_kk = 14)
    {
		if($params['status_bayar'] == "Sudah Bayar"){
			$query = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['id_kelas']) && $params['id_kelas'] != ""){
				$query->where('b.id_kelas', $params['id_kelas']);
			}
			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$query->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$query->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}
		}else{
			$pembayaran = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['id_kelas']) && $params['id_kelas'] != ""){
				$pembayaran->where('b.id_kelas', $params['id_kelas']);
			}
			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$pembayaran->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$pembayaran->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}

			foreach($pembayaran->get() as $sis)
			{
				$nis[] = $sis->nis;
			}

			$query = DB::table('tb_siswa as a')
					->join('tb_kelas as b','a.id_kelas','=','b.id')
					->select('a.*','b.tingkat_kelas');
			if(!empty($nis)){
				$query->whereNotIn('a.nis', $nis);
			}

		}


        return $query->get();
    }

	function get_pemasukan_spp($params,  $id_kk = 13)
    {
			$query = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$query->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$query->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}
		
        return $query->get();
    }

	function get_pemasukan_gedung($params,  $id_kk = 14)
    {
			$query = DB::table('tb_transaksi as a')
					->join('tb_siswa as b','a.nis','=','b.nis')
					->join('tb_kelas as c','b.id_kelas','=','c.id')
					->where('a.id_kk', $id_kk)
					->select('a.*','b.nama_siswa','b.angkatan','c.tingkat_kelas');

			if(!empty($params['bulan']) && $params['bulan'] != ""){
				$query->whereMonth('a.tanggal', $params['bulan']);
			}
			if(!empty($params['tahun_ajaran']) && $params['tahun_ajaran'] != ""){
				$query->where('a.tahun_ajaran', $params['tahun_ajaran']);
			}
		
        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table('tb_pembayaran as a')
				->join('tb_siswa as b','a.nis','=','b.nis')
				->select('a.*','b.nama as nama_siswa','tanggal_lahir','jenis_kelamin','alamat','no_telp','jurusan','agama','kelas')
				->where('a.id', $id);

		return $query->first();
	}
	

	function get_by( $where )
	{
		$query = DB::table('tb_pembayaran as a')
		->join('tb_siswa as b','a.nis','=','b.nis')
		->select('a.*','b.nama as nama_siswa','tanggal_lahir','jenis_kelamin','alamat','no_telp','jurusan','agama','kelas')
		->where($where);

		return $query->first();
	}

	function get_by_in( $where, $data )
	{
		return self::whereIn($where, $data)->get();
	}

	function update_data($data, $id)
	{
		return self::where($this->index_key,$id)->update($data);
	}

	function update_by($data, Array $where)
	{
		$query = DB::table($this->table)->where($where);
		return $query->update($data);
	}

	function gen_code( $format )
	{
		$max_number = self::all()->max($this->index_key2);
		$noUrut = (int) substr($max_number, 3, 3);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%03s", $noUrut);

		return (string) $no_generate;
	}

	// function collection_detail($id)
    // {
	// 	$query = DB::table('tb_transaksi as a')
	// 			->join('tb_transaksi_detail as b','a.id','=','b.id_transaksi')
	// 			->where('b.id_transaksi', $id)
	// 			->select('b.*');
    //     return $query->get();
    // }

}
