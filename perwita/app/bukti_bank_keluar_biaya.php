<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bukti_bank_keluar_biaya extends Model
{
    protected $table = 'bukti_bank_keluar_biaya';
    protected $primaryKey = 'bbkb_id';
    protected $fillable = array('bbkb_id','bbkb_idbbk', 'bbkb_akun','bbkb_dk');
    
	public $incrementing = false;

}
