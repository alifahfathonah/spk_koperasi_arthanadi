<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pengeluaran_detail_m extends Model
{
	protected $table = 'tb_pengeluaran_detail';
	protected $index_key = 'id';
	protected $index_key2 = 'id_pengeluaran';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_pengeluaran' => "required",
				'akun_id' => 'required',
            ],
			'update' => [
				'id_pengeluaran' => "required",
				'akun_id' => 'required',
            ],
        ];
	}

    function get_all()
    {
        return self::get();
    }

	function collection($id)
	{
		$query = DB::table("{$this->table} as a")
				->leftjoin('tb_akun as b','b.id','=','a.akun_id')
				->select('a.*','b.nama_akun','b.kode_akun','b.id as akun_id')
				->where("a.{$this->index_key2}", $id);
				
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
		return self::where($where)->first();
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
