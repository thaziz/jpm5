<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itemsupplier extends Model
{
    protected $table = 'itemsupplier';
    protected $primaryKey = 'is_id';
    protected $fillable = array('is_kodeitem','is_id','is_harga','is_supplier', 'is_idsup');
	public $incrementing = false;

}
