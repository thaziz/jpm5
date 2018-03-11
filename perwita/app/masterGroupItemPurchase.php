<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterGroupItemPurchase extends Model
{
    protected $table = 'groupitem';
    protected $primaryKey = 'kode_groupitem';
    protected $fillable = array('kode_groupitem', 'keterangan_groupitem');
    public $timestamps = false;
    public $incrementing = false;


}
