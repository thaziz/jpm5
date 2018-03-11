<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class biaya_penerus_kas_detail extends Model
{
    protected $table = 'biaya_penerus_kas_detail';
    protected $primaryKey = 'bpk_id';
    protected $fillable = array('bpkd_id',
							  	'bpkd_bpk_id',  	  	 
							  	'bpkd_bpk_dt', 	
							  	'bpkd_no_resi',  	
							  	'bpkd_kode_cabang_awal', 	
							  	'bpkd_tanggal',    
							  	'bpkd_pengirim',		 
							  	'bpkd_penerima',	  	
							  	'bpkd_asal',
							  	'bpkd_tujuan',	
							  	'bpkd_status_resi',	
							  	'bpkd_tarif',
							  	'bpkd_tarif_penerus',
							  	'updated_at',
							  	'created_at',
							  	'bpk_comp',
							  	'bpkd_pembiayaan'
						);
  
    public $incrementing = false;

}
