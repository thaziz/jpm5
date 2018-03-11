<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spptb_purchase extends Model
{
    protected $table = 'spp_totalbiaya';
    protected $primaryKey = 'spptb_id';
    protected $fillable = array('spptb_id','spptb_idspp','spptb_supplier','spptb_totalbiaya');
 
public $incrementing = false;

}
