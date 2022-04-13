<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pengeluaran_m extends Model
{
	protected $table = 'tb_pengeluaran';
	protected $index_key = 'id';
	protected $index_key2 = 'id_pengeluaran';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_pengeluaran' => "required|unique:{$this->table}",
				'tanggal' => 'required',
            ],
			'update' => [
				'tanggal' => 'required',
            ],
        ];

	}

    function get_all()
    {
		$query = DB::table("{$this->table} as a")
				->join('tb_akun as b','b.id','=','a.akun_id')
				->select('a.*','b.nama_akun')
				->orderBy('a.tanggal','asc');
        return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table("{$this->table} as a")
			->join('tb_akun as b','b.id','=','a.akun_id')
			->where("a.{$this->index_key}", $id)
			->select('a.*','b.nama_akun');

		return $query->first();
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


}
