<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class masterbank_dt extends Model
{
    protected $table = 'masterbank_dt';
    protected $primaryKey = 'mbdt_id';
    protected $fillable = array('mbdt_id','mbdt_kodebank', 'mbdt_noseri','mbdt_setuju','mbdt_status','mbdt_seri');
	public $incrementing = false;

	
}
