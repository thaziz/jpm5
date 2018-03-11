<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class purchase_orderdt extends Model
{
    protected $table = 'pembelian_orderdt';
    protected $primaryKey = 'podt_id';
    protected $fillable = array('podt_id' , 'podt_kodeitem' , 'podt_approval', 'podt_qtykirim' , 'podt_supplier' , 'podt_jumlahharga' , 'podt_statuskirim' , 'podt_idspp', 'podt_idpo','podt_lokasigudang' , 'podt_tglkirim');
	public $incrementing = false;

}
