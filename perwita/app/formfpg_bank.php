<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formfpg_bank extends Model
{
    protected $table = 'fpg_cekbank';
    protected $primaryKey = 'fpgb_id';
    protected $fillable = array('fpgb_id', 'fpgb_kodebank', 'fpgb_jenisbayarbank', 'fpgb_nocheckbg',  'fpgb_jatuhtempo' , 'fpgb_nominal' , 'fpgb_hari', 'fpgb_cair', 'fpbg_setuju');
	public $incrementing = false;

}
