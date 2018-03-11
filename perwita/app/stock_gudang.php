<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class stock_gudang extends Model
{
    protected $table = 'stock_gudang';
    protected $primaryKey = 'sg_id';
    protected $fillable = array('sg_id','sg_cabanggudang','sg_item','sg_qty', 'sg_minstock');
 
public $incrementing = false;

}
