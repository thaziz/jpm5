<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class fakturpembeliandt extends Model
{
    protected $table = 'faktur_pembeliandt';
    protected $primaryKey = 'fpdt_id';
    protected $fillable = array('fpdt_id', 'fpdt_idfp','fpdt_kodeitem','fpdt_qty' , 'fpdt_gudang' , 'fpdt_harga', 'fpdt_totalharga','fpdt_updatestock' , 'fpdt_biaya');
 
    public $incrementing = false;

}
