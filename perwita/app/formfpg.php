<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formfpg extends Model
{
    protected $table = 'fpg';
    protected $primaryKey = 'idfpg';
    protected $fillable = array('fpg_tgl', 'fpg_jenisbayar', 'fpg_totalbayar', 'fpg_uangmuka',  'fpg_cekbg' , 'fpg_keterangan' , 'fpg_cabang', 'fpg_idbank');
	public $incrementing = false;

}
