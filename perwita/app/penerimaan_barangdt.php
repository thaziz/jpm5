<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class penerimaan_barangdt extends Model
{
    protected $table = 'penerimaan_barangdt';
    protected $primaryKey = 'pbdt_id';
    protected $fillable = array('pbdt_idpb', 'pbdt_id' , 'pbdt_item' , 'pbdt_qty' , 'pbdt_lpb' , 'pbdt_suratjalan' , 'pbdt_po' , 'pbdt_hpp' , 'pbdt_updatestock' , 'pbdt_date' , 'pbdt_status', 'pbdt_idspp', 'pbdt_sampling');
	public $incrementing = false;
	

	public function one()
	{
		return $this->hasOne(penerimaan_barang::class,'pb_id');
	}
}
