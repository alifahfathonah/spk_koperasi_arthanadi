<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proses_spk_m extends Model
{
	protected $table = 'tb_pengajuan';
	protected $index_key = 'id';
	protected $index_key2 = 'kode_pengajuan';
    public $timestamps  = false;

	public $rules;

    public function __construct()
	{
        $this->rules = [

        ];
	}

    function get_all($params = [])
    {
		$query = DB::table("{$this->table} as a")
				->join('tb_alternatif as b','a.id_alternatif','=','b.id')
				->join('tb_nasabah as c','b.id_nasabah','=','c.id')
				->join('tb_kriteria as d','a.jaminan','=','d.id')
				->join('tb_kriteria as e','a.karakter','=','e.id')
				->join('tb_kriteria as f','a.kondisi_hutang','=','f.id')
				->select(
					'a.*',
					'a.id as pengajuan_id',
					'b.kode_alternatif',
					'c.nama_nasabah',
					'c.alamat_nasabah',
					'c.telepon',
					'd.bobot_kriteria as C1',
					'e.bobot_kriteria as C2',
					'a.pendapatan as C3',
					'a.pengeluaran as C4',
					'a.kemampuan as C5',
					'f.bobot_kriteria as C6'
				)
				->where(['a.sudah_proses' => 0, 'a.aktif' => 1]);

				if(!empty($params['date_start']) && !empty($params['date_end'])){
					$query->whereBetween('a.tgl_pengajuan',[$params['date_start'],$params['date_end']]);
				}
				
		return $query->get();
    }

    function insert_data($data)
	{
		return self::insert($data);
	}

	function get_one($id)
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_alternatif as b','a.id_alternatif','=','b.id')
				->join('tb_nasabah as c','b.id_nasabah','=','c.id')
				->join('tb_kriteria as d','a.jaminan','=','d.id')
				->join('tb_kriteria as e','a.karakter','=','e.id')
				->join('tb_kriteria as f','a.kondisi_hutang','=','f.id')
				->select(
					'a.*',
					'a.id as pengajuan_id',
					'b.kode_alternatif',
					'c.nama_nasabah',
					'c.alamat_nasabah',
					'c.telepon',
					'd.bobot_kriteria as C1',
					'e.bobot_kriteria as C2',
					'a.pendapatan as C3',
					'a.pengeluaran as C4',
					'a.kemampuan as C5',
					'f.bobot_kriteria as C6'
				)
				->where("a.{$this->index_key}", $id);
				
		return $query->first();
	}

	function get_by( $where )
	{
		$query = DB::table("{$this->table} as a")
				->join('tb_pengajuan as b','a.id_pengajuan','=','b.id')
				->join('tb_nasabah as c','b.id_nasabah','=','c.id')
				->join('tb_kriteria as d','b.jaminan','=','d.id')
				->join('tb_kriteria as e','b.karakter','=','e.id')
				->join('tb_kriteria as f','b.kondisi_hutang','=','f.id')
				->select(
					'a.*',
					'b.id as pengajuan_id',
					'b.id_pengajuan',
					'b.id_nasabah',
					'c.nama_nasabah',
					'c.alamat_nasabah',
					'c.telepon',
					'd.bobot_kriteria as C1',
					'e.bobot_kriteria as C2',
					'b.pendapatan as C3',
					'b.pengeluaran as C4',
					'b.kemampuan as C5',
					'f.bobot_kriteria as C6'
				)
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
