<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Hasil_fucom_smart_m extends Model
{
	protected $table = 'tb_hasil';
	protected $index_key = 'id';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{

	}

    function get_all($params)
    {
		$query = DB::table('tb_hasil as a')
				->join('tb_pengajuan as b','a.id_pengajuan','=','b.id_pengajuan')
				->join('tb_alternatif as c','b.id_alternatif','=','c.id')
				->join('tb_nasabah as d','c.id_nasabah','=','d.id')
				->select(
					'a.*',
					'b.tgl_pengajuan',
					'd.nama_nasabah'
				)
				->where('c.aktif', 1)
				->orderBy('b.tgl_pengajuan', 'desc');

		if(!empty($params['date_start']) && !empty($params['date_end'])){
			$query->whereBetween('b.tgl_pengajuan',[$params['date_start'],$params['date_end']]);
		}

		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		return self::where($this->index_key, $id)->first();
	}

	function get_by( $where )
	{

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
		$query = self::where($where);
		return $query->update($data);
	}

}
