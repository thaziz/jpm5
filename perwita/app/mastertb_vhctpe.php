<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mastertb_vhctpe extends Model
{
    protected $table = 'tb_vhctpe';
    protected $primaryKey = 'id_vhctpe';
    protected $fillable = array('id_vhctpe' , 'kode', 'nama_kendaraan' , 'status' , 'urutan');
    public $timestamps = false;
    public $incrementing = false;


}
