<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bukti_bank_keluar_dt extends Model
{
    protected $table = 'bukti_bank_keluar_detail';
    protected $primaryKey = 'bbkd_id';
    protected $fillable = array('bbkd_id', 'bbkd_idbbk','bbkd_nocheck' , 'bbkd_jatuhtempo' , 'bbkd_nominal' , 'bbkd_keterangan' , 'bbkd_bank' , 'bbkd_supplier' , 'bbkd_tglfpg');
    
	public $incrementing = false;

}
