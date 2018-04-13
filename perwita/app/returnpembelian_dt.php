<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returnpembelian_dt extends Model
{
    protected $table = 'returnpembelian_dt';
    protected $primaryKey = 'cndt_id';
    protected $fillable = array('rndt_id' , 'rndt_idrn' , 'rndt_item' , 'rndt_qtypo' , 'rndt_qtyreturn' , 'rndt_harga', 'rndt_totalharga' , ); 
    public $incrementing = false;

}
