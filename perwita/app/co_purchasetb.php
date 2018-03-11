<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class co_purchasetb extends Model
{
    protected $table = 'confirm_order_tb';
    protected $primaryKey = 'cotb_id';
    protected $fillable = array('cotb_id','cotb_idco','cotb_supplier','cotb_totalbiaya');
	public $incrementing = false;

}
