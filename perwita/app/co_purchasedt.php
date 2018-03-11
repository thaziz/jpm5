<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class co_purchasedt extends Model
{
    protected $table = 'confirm_order_dt';
    protected $primaryKey = 'codt_id';
    protected $fillable = array('codt_id','codt_idco','codt_seq','codt_kodeitem','codt_qtyrequest','codt_qtyapproved','codt_supplier','codt_harga');
	public $incrementing = false;

}
