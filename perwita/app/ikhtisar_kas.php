<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ikhtisar_kas extends Model
{
    protected $table = 'ikhtisar_kas';
    protected $primaryKey = 'ik_id';
    protected $fillable = array('ik_id', 'ik_nota', 'ik_tgl_awal', 'ik_keterangan', 'ik_comp', 'ik_total', 'ik_edit', 'ik_status', 'ik_tgl_akhir' , 'ik_pelunasan');
	public $incrementing = false;

	

	//public $dateFormat = 'Y-m-d H:i:s+';


}
