<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class biaya_penerus_dt extends Model
{
    protected $table = 'biaya_penerus_dt';
    protected $primaryKey = 'bpd_id';
    protected $fillable = array('bpd_id',
    							'bpd_bpid', 
	    						'bpd_bpdetail',
	    						'bpd_pod',
	    						'bpd_tgl',
	    						'bpd_akun_biaya' ,
	    						'bpd_nominal',
	    						'bpd_tarif_resi',
	    						'bpd_debit',
	    						'bpd_memo',
	    						'bpd_akun_hutang',
	    						'created_at',
	    						'updated_at',
	    						'bpd_status');
  
    public $incrementing = false;

}
