<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cndn_dt extends Model
{
    protected $table = 'cndnpembelian_dt';
    protected $primaryKey = 'cndt_id';
    protected $fillable = array('cndt_id' , 'cndt_idcn' , 'cndt_idfp' , 'cndt_tgl' , 'cndn_sisahutang' , 'cndt_jenisppn', 'cndt_nilaippn' , 'cndt_hasilppn' , 'cndt_jenispph' , 'cndt_nilaipph' , 'cndt_hasilpph'); 
    public $incrementing = false;

}
