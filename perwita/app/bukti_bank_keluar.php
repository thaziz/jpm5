<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bukti_bank_keluar extends Model
{
    protected $table = 'bukti_bank_keluar';
    protected $primaryKey = 'bbk_id';
    protected $fillable = array('bbk_id', 'bbk_nota', 'bbk_kodebank', 'bbk_keterangan',  'bbk_cekbg' , 'bbk_biaya' , 'bbk_total');
	public $incrementing = false;

}
