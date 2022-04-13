<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pengajuan_m extends Model
{
	protected $table = 'tb_pengajuan';
	protected $index_key = 'id';
	protected $index_key2 = 'id_pengajuan';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [
            'insert' => [
                'id_pengajuan' => "required|unique:$this->table",
				'tgl_pengajuan' => 'required',
            ],
			'update' => [
				'tgl_pengajuan' => 'required',
            ],
        ];
	}

    function get_all()
    {
		$query = DB::table("{$this->table} as a")
				->join('tb_nasabah as b','a.id_nasabah','=','b.id')
				->select('a.*','b.nama_nasabah','b.alamat_nasabah','b.telepon');
				
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
				->select('a.*','b.nama_nasabah','b.alamat_nasabah','b.telepon')
				->where("a.{$this->index_key}", $id);
				
		return $query->first();
	}

	function get_by( $where )
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_nasabah as b','a.id_nasabah','=','b.id')
				->select('a.*','b.nama_nasabah','b.alamat_nasabah','b.telepon')
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
		$noUrut = (int) substr($max_number, 6, 6);
		$noUrut++;
		$code = $format;
		$no_generate = $code . sprintf("%06s", $noUrut);

		return (string) $no_generate;
	}

}
