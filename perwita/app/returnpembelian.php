<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class returnpembelian extends Model
{
    protected $table = 'returnpembelian';
    protected $primaryKey = 'rn_id';
    protected $fillable = array('rn_id', 'rn_tgl' , 'rn_supplier' , 'rn_subtotal' , 'rn_jenisppn' , 'rn_ppn' , 'rn_totalharga' , 'rn_nota' , 'rn_totalharga' , 'rn_nota' ,'rn_cabang');
  
    public $incrementing = false;

}
