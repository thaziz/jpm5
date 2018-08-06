<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class co_purchasedtpemb extends Model
{
    protected $table = 'confirm_order_dt_pemb';
    protected $primaryKey = 'codtk_id';
    protected $fillable = array('codtk_id','codtk_idco','codtk_seq','codtk_kodeitem','codtk_qtyrequest','codtk_qtyapproved','codtk_supplier','codtk_harga');
	public $incrementing = false;

}
