<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class formfpg_dt extends Model
{
    protected $table = 'fpg_dt';
    protected $primaryKey = 'fpdt_id';
    protected $fillable = array('fpgdt_idfpg', 'fpgdt_id', 'fpgdt_idfp', 'fpgdt_tgl',  'fpgdt_jatuhtempo' , 'fpgdt_jumlahtotal' , 'fpdt_uangmuka',  'fpgdt_pelunasan' , 'fpgdt_sisafaktur');
	public $incrementing = false;

}
