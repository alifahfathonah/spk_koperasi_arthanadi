<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pembayaran_detail_m extends Model
{
	protected $table = 'tb_pembayaran_detail';
	protected $index_key = 'id';
	protected $index_key2 = 'id_pembayaran';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_pembayaran' => 'required',
				'tanggal' => 'required',
				'nominal' => 'required',
            ],
			'update' => [
				'tanggal' => 'required',
				'nominal' => 'required',
            ],
        ];

	}

    function get_all()
    {
        return self::get();
    }

	function get_collection($id)
	{
		return self::where($this->index_key2, $id)->orderBy('tgl_pembayaran', 'asc')->orderBy('bulan', 'asc')->get();
	}

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table('tb_pembayaran as a')
				->join('tb_pembayaran_detail as b','a.id_pembayaran','=','b.id_pembayaran')
				->join('tb_siswa as c','a.nis','=','c.nis')
				->join('tb_user as d','b.id_user','=','d.id')
				->select('b.*','c.nis','c.nama as nama_siswa','c.tanggal_lahir','c.jenis_kelamin','c.alamat','c.no_telp','c.jurusan','c.agama','c.kelas','d.nama_user')
				->where("b.{$this->index_key}", $id);

		return $query->first();
	}

	function get_by( $where )
	{
		return self::where($where)->first();
	}

	
	function delete_by( $where )
	{
		return self::where($where)->delete();
	}

	function get_by_in( $where, $data )
	{
		return self::whereIn($where, $data)->get();
	}

	function update_data($data, $id)
	{
		return self::where($this->index_key, $id)->update($data);
	}

	function update_by($data, Array $where)
	{
		$query = DB::table($this->table)->where($where);
		return $query->update($data);
	}

}
