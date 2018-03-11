<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_mutation extends Model
{
    protected $table = 'stock_mutation';
    protected $primaryKey = 'sm_id';
    protected $fillable = array('sm_stock','sm_id','sm_comp','sm_date', 'sm_item' , 'sm_mutcat' , 'sm_qty' , 'sm_use' , 'sm_hpp' , 'sm_suratjalan' , 'sm_spptb');
 
public $incrementing = false;

}
