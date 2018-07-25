<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bonsempengajuan extends Model
{
    protected $table = 'bonsem_pengajuan';
    protected $primaryKey = 'bp_id';
    protected $fillable = array('bp_id','bp_cabang', 'bp_nominal','bp_keperluan' , 'created_by' , 'updated_by', 'bp_jatuhtempo', 'bp_bagian' , 'bp_setujukacab' , 'status_pusat' ,'bp_tgl' , 'bp_nota');
    
	public $incrementing = false;

}
