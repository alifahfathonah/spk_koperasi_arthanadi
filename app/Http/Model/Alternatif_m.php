<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Alternatif_m extends Model
{
	protected $table = 'tb_alternatif';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_alternatif';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'kode_alternatif' => "required|unique:$this->table",
				'id_nasabah' => "required|unique:$this->table",
            ],
			'update' => [
				'id_nasabah' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = DB::table("{$this->table} as a")
				->join('tb_nasabah as b','a.id_nasabah','=','b.id')
				->select(
					'a.*',
					'b.nama_nasabah',
					'b.alamat_nasabah',
					'b.telepon'
				)
				->where('a.aktif', 1);
				
		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_nasabah as b','a.id_nasabah','=','b.id')
				->select(
					'a.*',
					'b.nama_nasabah',
					'b.alamat_nasabah',
					'b.telepon'
				)
				->where('a.aktif', 1)
				->where("a.{$this->index_key}", $id);
				
		return $query->first();
	}

	function get_by( $where )
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_nasabah as b','a.id_nasabah','=','b.id')
				->select(
					'a.*',
					'b.nama_nasabah',
					'b.alamat_nasabah',
					'b.telepon'
				)
				->where('a.aktif', 1)
				->where($where);
				
		return $query->first();
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

	function gen_code( $format )
	{
		$max_number = self::all()->max($this->index_key2);
		$noUrut = (int) substr($max_number, 1, 1);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%01s", $noUrut);

		return (string) $no_generate;
	}

}
