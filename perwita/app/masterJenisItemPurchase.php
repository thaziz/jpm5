<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterJenisItemPurchase extends Model
{
    protected $table = 'jenis_item';
    protected $primaryKey = 'kode_jenisitem';
    protected $fillable = array('kode_jenisitem', 'keterangan_jenisitem');
    public $timestamps = false;
    public $incrementing = false;

}
