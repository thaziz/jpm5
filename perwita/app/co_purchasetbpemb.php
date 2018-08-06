<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class co_purchasetbpemb extends Model
{
    protected $table = 'confirm_order_tb_pemb';
    protected $primaryKey = 'cotbk_id';
    protected $fillable = array('cotbk_id','cotbk_idco','cotbk_supplier','cotbk_totalbiaya');
	public $incrementing = false;

}
