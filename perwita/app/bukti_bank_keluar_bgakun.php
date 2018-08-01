<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bukti_bank_keluar_bgakun extends Model
{
    protected $table = 'bukti_bank_keluar_akunbg';
    protected $primaryKey = 'bbkab_id';
    protected $fillable = array('bbkab_id','bbkab_idbbk', 'bbkab_akun','bbkab_dk' , 'bbkab_idfpg' , 'bbkab_nofpg' , 'bbkab_nocheck' , 'bbkab_keterangan' , 'bbkab_nominal');
    
	public $incrementing = false;

}
