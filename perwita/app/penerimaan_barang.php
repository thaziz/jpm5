<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penerimaan_barang extends Model
{
    protected $table = 'penerimaan_barang';
    protected $primaryKey = 'pb_id';
    protected $fillable = array('pb_id', 'pb_comp', 'pb_date', 'pb_status', 'pb_po', 'pb_updatestock','pb_lpb' , 'pb_suratjalan', 'status_faktur', 'time_faktur', 'pb_supplier', 'pb_gudang');
	public $incrementing = false;


	public function many()
	{
		return $this->hasMany(penerimaan_barangdt::class,'pbdt_idpb');
	}
}
