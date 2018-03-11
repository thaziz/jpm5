<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterGudangPurchase extends Model
{
    protected $table = 'mastergudang';
    protected $primaryKey = 'mg_id';
    protected $fillable = array('mg_namagudang', 'mg_cabang', 'mg_alamat');
    public $timestamps = false;
    public $incrementing = false;

}
