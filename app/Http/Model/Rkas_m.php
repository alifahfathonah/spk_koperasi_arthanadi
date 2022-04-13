<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Rkas_m extends Model
{
	protected $table = 'tb_rkas';
	protected $index_key = 'id';
	protected $index_key2 = 'id_rkas';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_rkas' => "required|unique:{$this->table}",
				'tanggal' => 'required',
                'keterangan' => 'required',
            ],
			'update' => [
				'tanggal' => 'required',
                'keterangan' => 'required',
            ],
        ];

	}

    function get_all()
    {
        return self::get();
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
		return self::where($this->index_key,$id)->update($data);
	}

	function update_by($data, Array $where)
	{
		$query = DB::table($this->table)->where($where);
		return $query->update($data);
	}


}
